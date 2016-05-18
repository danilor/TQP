<?php namespace Tiqueso\Http\Controllers;
use Illuminate\Support\Str;
use Request;
use Input;
use Redirect;
use Auth;
use Tiqueso\categoria_producto;
use Tiqueso\producto;
use Validator;
use Config;
use Hash;
use Session;
use DB;
use App\clases\Comunes;
use App\clases\Usuario;
use App\clases\Correo;


//This class will take care of the login information
class AdminProcesosControllador extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|iniciar_proceso'			=>	'iniciarProceso',
		'post|salvar_proceso'			=>	'salvarProceso',
		'get|ver'						=>	'listarProcesos',
		'get|registrar_de_proceso'		=>	'registrarDeProceso',
		'post|salvar_producto'			=>	'salvarProducto',

	);

	public function __construct(){
		//$this->middleware('guest');
	}

	public function principal(){
		$usuario = Auth::user();
		if(!Auth::check()){
			return Redirect::to('/ingresar?accesso&url='.Request::url());
		}
		$segmento = strtolower(Request::segment(2));
		$request = strtolower(Request::getMethod());
		$urlrule = "$request|$segmento";
		if(isset($this->reglas[$urlrule])){
			$g = $this->reglas[$urlrule];
			return $this->$g($usuario);
		}else{
			return Comunes::enviar404();
		}
	}

	/*
         * Función que muestra la pagina para iniciar proceso
         * */
	public function iniciarProceso($usuario){

		$data["usuario"] = $usuario;
		$data["productos"] 	=
			\Tiqueso\producto::select('productos.*','tipo_productos.nombre AS nombre_tipo')
				->leftJoin('tipo_productos', 'productos.codigo_tipo', '=', 'tipo_productos.codigo')
				->where( "productos.estado" , "1" )
				->where('productos.borrado',0)
				-> get();
		return view('admin_procesos/iniciar_proceso')->with($data);
	}

	/*
	 * Esta función se encarga de salvar el proceso
	 * */
	public function salvarProceso($usuario){
		//Primero validamos la información
		$url = \URL::previous();
		$url = explode("?", $url)[0]; //Removemos el query string en caso de que exista
		$rules = array(
			'detalle' => Comunes::reglas('textogenerico', false),
		);
		$validador = Validator::make(Input::all(), $rules);
		if ($validador->fails()) {
			return Redirect::to($url)->withErrors($validador)->withInput();;
		}

		//Ahora necesitamos hacer unas validaciones manuales

		if(Input::get('productos') === null){
			return Redirect::to($url)->withErrors(["No existe ningún producto"])->withInput();;
		}

		if(!is_array(Input::get('productos'))){
			return Redirect::to($url)->withErrors(["Lista de productos inválidos"])->withInput();;
		}

		$productos_temporales = Input::get('productos');
		$productos_finales = [];

		foreach($productos_temporales AS $p){
			if( trim($p) == "" ){
				return Redirect::to($url)->withErrors(["Uno o más de los códigos viene vacío"])->withInput();
			}
			if( strlen($p) != (int) config('data.largo_codigos') ){
				return Redirect::to($url)->withErrors(["Código $p inválido. No cumple con el formato y largo requerido"])->withInput();
			}
			$productos_finales[] = $p;
		}

		foreach($productos_finales AS $p){ // Tenemos que cerrar cada uno de los productos finales
			producto::cerrarProducto($p);
		}

		//Si llega hasta aquí quiere decir que todo está bien. Podemos almacenar la información

		$dated = new \DateTime(); // Obtenemos la fecha actual

		$proceso 		= 		new \Tiqueso\proceso();
		$proceso		->		unico				=		'TQP'.date('Ymdhis').str_random(64);
		$proceso		->		iniciado_fecha		=		$dated;
		$proceso		->		iniciado_por		=		$usuario->id;
		$proceso		->		productos_proceso	=		implode(',',$productos_finales);
		$proceso		->		estado				=		1;
		$proceso		->		detalle				=		Input::get('detalle');

		$proceso		->		save(); //Salvamos la información del proceso


		//Ya que salvamos el proceso, debemos de salvar también los usuarios involucrados.
		//Primero borramos los existentes (que realmente no deberían de existir)

		DB::table('usuario_proceso')->where('proceso_id',$proceso->id)->delete();
		//Ahora verificamos si la variable de usuarios existe y viene completa.
		if(  is_array(Input::get('usuarios'))  ){
			foreach(Input::get('usuarios') AS $u){
				DB::table('usuario_proceso')->insertGetId([
					'usuario_id'			=>			$u,
					'proceso_id'			=>			$proceso->id
				]);
			}

		}


		return Redirect::to('/admin_procesos/ver');

		//Es momento de salvar la información
	}

	/*
	 * Esta función se encarga de mostrar la lista de procesos
	 * */
	public function listarProcesos($usuario){
		$data["usuario"] = $usuario;
		$procesos = \Tiqueso\proceso::where('estado',1)->orderBy('iniciado_fecha','desc')->get();
		$data["procesos"] 	= $procesos;
		return view('admin_procesos/ver')->with($data);
	}

	/*
	 * Esta función se encarga de mostrar la página para registrar un producto por medio de un proceso
	 * */
	public function registrarDeProceso($usuario){
		$data["usuario"] = $usuario;
		$id = Request::segment(3); //Obtenemos el ID.

		$proceso = \Tiqueso\proceso::find($id); // Buscamos el proceso por ID
		if($proceso == null){
			//Si el proceso no existe, mostramos una página de error.
			return view('admin_procesos/no_encontrado')->with($data);
		}
		return view('admin_procesos/registrar_producto')->with($data);
	}

	/*
	 * Esta función almacena un producto por medio de post.
	 * */
	public function salvarProducto($usuario){

		//Primero es necesario validar todos los campos.
		$url = \URL::previous();
		$url = explode("?", $url)[0]; //Removemos el query string en caso de que exista
		$pt = null;
		$dated = new \DateTime(); //Obtenemos la fecha actual
		$rules = array(
			'proceso_id' 		=> Comunes::reglas('numero_libre', true,'exists:procesos,id'),
			'presentacion' 		=> Comunes::reglas('textogenerico', true,'exists:producto_presentaciones,codigo'),
			'tipo_producto'		=> Comunes::reglas('textogenerico', true, 'exists:tipo_productos,codigo'),
			'tanda' 			=> Comunes::reglas('numero', true),
			'vencimiento' 		=> Comunes::reglas('fecha', true),
			'unidades' 			=> Comunes::reglas('numero_libre', false),
			'humedad' 			=> Comunes::reglas('numero_libre', false),
		);
		$validador = Validator::make(Input::all(), $rules);

		if ($validador->fails()) {
			return Redirect::to($url)->withErrors($validador)->withInput();
		}

		$presentacion = \Tiqueso\producto_presentacion::where("codigo",Input::get("presentacion"))->first();
		$proceso = \Tiqueso\proceso::find(Input::get("proceso_id")); //Obtenemos el objeto del proceso porque debemos de cerrar el proceso luego.


		$producto = new \Tiqueso\producto(); //Creamos el nuevo objeto de producto

		$producto -> codigo_tipo		=		Input::get('tipo_producto');
		$producto -> codigo_proveedor	=		Input::get('presentacion');
		$producto -> nombre_proveedor	=		'TIQUESO';
		$producto -> dia_juliano		=		str_pad(date('z'),3,'0',STR_PAD_LEFT);
		$producto -> tanda				=		Input::get('tanda');
		$producto -> obtenerCodigoFinal();
		$vencimiento = \DateTime::createFromFormat(config('region.formato_fecha'),Input::get('vencimiento'));
		$producto -> vencimiento		=		$vencimiento;
		$producto -> unidades			=		Input::get('unidades');
		$producto -> humedad			=		Input::get('humedad');
		$producto -> detalle			=		Input::get('detalle');
		$producto -> estado				=		1;
		$producto -> creado_por			=		$usuario->id;
		$producto -> registrado			=		$dated;
		$producto -> modificado			=		$dated;
		$producto -> producto_tiqueso	=		1; //Esto indica que el producto es un producto tiqueso
		$producto -> proceso_padre		=		$proceso ->id; // El proceso padre del cual fue obtenido el producto.
		$producto -> materias_primas	=		$proceso -> productos_proceso; //Obtenemos todas las materias primas que entraron al proceso.

		$producto -> save(); //Salvamos la información


		if((int)Input::get('almacenaje')>0){//Quiere decir que tenemos que guardar un registro de almacenaje

			$almacenaje = \Tiqueso\Almacenaje::find((int)Input::get('almacenaje'));
			if($almacenaje != null){ //Esto es para verificar con anticipación si el almacenaje realmente existe
				$historial = new \Tiqueso\historial_almacenaje();
				$historial -> producto_id = $producto->id;
				$historial -> producto_codigo = $producto->codigo;
				$historial -> almacenaje_id = $almacenaje->id;
				$historial -> fecha_movimiento = new \DateTime();
				$historial -> movido_por = $usuario->id;
				$historial -> save();
			}
		}


		// A continuación, cerramos el proceso
		$proceso -> finalizado_fecha = $dated;
		$proceso -> finalizado_por = $usuario->id;
		$proceso -> estado = 0;
		$proceso -> save();

		return Redirect::to('admin_procesos/ver');

	}

}
