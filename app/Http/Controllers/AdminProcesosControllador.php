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


}
