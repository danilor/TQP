<?php namespace Tiqueso\Http\Controllers;
use App\clases\Almacenaje;
use Illuminate\Support\Str;
use Request;
use Input;
use Redirect;
use Auth;
use Tiqueso\categoria_producto;
use Tiqueso\historial_almacenaje;
use Tiqueso\producto;
use Tiqueso\proveedor;
use Tiqueso\registro_producto;
use Validator;
use Config;
use Hash;
use Session;
use DB;
use App\clases\Comunes;
use App\clases\Usuario;
use App\clases\Correo;


//This class will take care of the login information
class AdminProductosControllador extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|'                      	=>  'tablero',
		'get|categorias'                =>  'categorias',
		'get|modificar_categoria'       =>  'modificarCategoria',
		'get|borrar_categoria'          =>  'borrar_categoria',
		'post|salvar_categoria_producto'=>	'salvarCategoriaProducto',
		'get|tipos'                		=>  'tipos',
		'get|modificar_tipo'       		=>  'modificarTipo',
		'post|salvar_tipo_producto'		=>	'salvarTipoProducto',
		'post|anadir_tipo_producto'		=>	'anadirTipoProducto',
		'get|borrar_tipo'          		=>  'borrar_tipo',
		'get|registrar_nuevo'   		=>  'registrarProducto',
		'get|registrar_ingreso'   		=>  'registrarIngreso',
		'post|salvar_registrar_ingreso'	=>  'salvarRegistrarIngreso',
		'post|registrar_ingreso_ajax'	=>  'registrarIngresoAjax',
		'post|salvar_producto'			=>	'salvarProducto',
		'get|ver'						=>	'verProductos',
		'get|iniciar_proceso'			=>	'iniciarProceso',
		'get|ficha_producto'			=>	'fichaProducto',
		'post|ficha_producto'			=>	'cambiarUbicacion',
		'get|sacar_producto'			=>	'sacarProducto',
		'get|buscar'					=>	'buscarProductos',
		'get|resumen_registro'			=>	'resumenRegistro',

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

	public function categorias($usuario){
		$data["usuario"] = $usuario;
		return view('admin_productos/categorias')->with($data);

	}

	/*Función que se encarga únicamente de borrar una categoría*/
	public function borrar_categoria($usuario){
		$id = Request::segment(3);
		$cat = categoria_producto::where("id",$id);
		if($cat != null) $cat->delete(); //Borramos solamente si no es nulo
		return Redirect::to("/admin_productos/categorias"); //Redirigimos de nuevo a la página de categorías
	}

	/*
	 * Función que muestra la página para modificar categoría. Estas categorías
	 * son batante simples y solo incluyen un nombre por el momento de escribir este comentario [2016-04-24]
	 * */
	public function modificarCategoria($usuario){
		$data["usuario"] = $usuario;
		// PC indica Producto Categoría
		$pc = null;
		if(	is_numeric(Request::segment(3) ) ){
			$pc = \Tiqueso\categoria_producto::where("id",Request::segment(3)) -> first(); //Obtenemos la categoría. Si no existe, devuelve null
		}
		$data["pc"] = $pc;
		return view('admin_productos/modificar_categoria')->with($data);
	}

	/*
	 * Función que permite salvar la información de la categoría de un producto
	 * */
	public function salvarCategoriaProducto($usuario){
		$url = \URL::previous();
		$url = explode("?",$url)[0]; //Removemos el query string en caso de que exista

		if(Input::get("id") != ""){ //Verificamos si la categoría existe o es nueva
			$u = \Tiqueso\categoria_producto::where("id",Input::get("id"))->first();
		}else{
			$u = new \Tiqueso\categoria_producto();
			$u->created_at = new \DateTime();
		}
		//Validamos la información. En este caso es poca información, por ello se vuelve fácil
		$rules = array(
			'nombre' 		=> Comunes::reglas('textogenerico', true),
			'detalles' 		=> Comunes::reglas('textogenerico', false),
		);
		$validador = Validator::make(Input::all(), $rules);
		if ($validador -> fails()) {
			return Redirect::to($url) -> withErrors($validador)->withInput();;
		}

		//Es momento de salvar la información

		//Se establecen los detalles
		$u->nombre 		= Input::get("nombre");
		$u->detalles 	= Input::get("detalles");
		$u->updated_at = new \DateTime(); //Actualizamos la fecha de la actualización
		$u->save(); //Salvamos la información

		//Información almacenada
		$url = "/admin_productos/modificar_categoria/".$u->id."?salvado=y&" . str_random(16); //Le añadimos un string random al final del URL para evitar el cache y para volver la URL más difícil de leer.
		return Redirect::to( $url  );
	}

	public function tipos($usuario){
		$data["usuario"] = $usuario;
		return view('admin_productos/tipos')->with($data);
	}

	/*
	 * Función que muestra la página para modificar tipo.
	 * */
	public function modificarTipo($usuario){
		$data["usuario"] = $usuario;
		// PT indica Producto Tipo
		$pt = null;
		if(	(Request::segment(3) ) != "" ){
			$pt = \Tiqueso\tipo_producto::where("codigo",Request::segment(3)) -> first(); //Obtenemos la categoría. Si no existe, devuelve null
		}

		if($pt == null){
			return Redirect::to( "/admin_productos/tipos/?error=El código del producto no existe" ); //Retornamos a la lista porque el ID es inexistente
		}
		$data["pt"] = $pt;
		return view('admin_productos/modificar_tipo')->with($data);
	}

	/*
	 * Función que permite salvar la información del tipo de un producto
	 * */
	public function salvarTipoProducto($usuario)
	{
		$url = \URL::previous();
		$url = explode("?", $url)[0]; //Removemos el query string en caso de que exista
		$pt = null;
		if ( Input::get("codigo") != "") {
			$pt = \Tiqueso\tipo_producto::where("codigo", Input::get("codigo"))->first(); //Obtenemos la categoría. Si no existe, devuelve null
		}

		if ($pt == null) {
			return Redirect::to("/admin_productos/tipos/?error=El código del producto no existe"); //Retornamos a la lista porque el ID es inexistente
		}

		$rules = array(
			'nombre' => Comunes::reglas('textogenerico', true),
			'unidad' => Comunes::reglas('textogenerico', true),
			'vida_util' => Comunes::reglas('numero', true),
			'detalle' => Comunes::reglas('textogenerico', false),
			'caracteristicas' => Comunes::reglas('textogenerico', false),
		);
		$validador = Validator::make(Input::all(), $rules);

		if ($validador->fails()) {
			return Redirect::to($url)->withErrors($validador)->withInput();;
		}

		//Es momento de salvar la información

		/*
		 * Mostrar es una variable que indica si el producto (este tipo) se tiene que mostrar en la página principal
		 * */
		$mostrar = 0;

		if(Input::get("mostrar") == "y"){
			$mostrar = 1;
		}

		//Se establecen los detalles
		$pt->nombre 			= Input::get("nombre");
		$pt->detalle 			= Input::get("detalle");
		$pt->caracteristicas 	= Input::get("caracteristicas");
		$pt->presentacion 		= Input::get("presentacion");
		$pt->unidad 			= Input::get("unidad");
		$pt->vida_util 			= (int)Input::get("vida_util");
		$pt->mostrar 			= $mostrar;
		$pt->updated_at 		= new \DateTime(); //Actualizamos la fecha de la actualización
		$pt->save(); //Salvamos la información


		// Luego de salvado (primero salvamos en caso de que sea un nuevo usuario porque necesitamos el ID
		// buscamos y almacenamos la imagen (si existe) y la

		$rules = array(
			'image' 					=> 'image|required',
		);
		$validador = Validator::make(Input::all(), $rules);
		if (!$validador -> fails()) {
			if(Input::file("image") != null) {
				$IMAGE = Input::file("image");
				$nuevoNombre = "TIPO_PRODUCTO_" . $pt->codigo . "_" . date("Ymd") . str_random(8) . '.' . $IMAGE->getClientOriginalExtension(); //Creamos el nuevo nombre con que lo vamos a almacenar
				if ((int)$IMAGE->getClientSize() > (int)Config::get("archivos.tamano_maximo")) {
					return Redirect::to($url)->withErrors(["Imágen supera el tamaño máximo"])->withInput();;
				}
				//dd(base_path() . '/public/'.Config::get("paths.UPLOADS").'/'.Config::get("paths.USERS").'/'. $imageName);
				$ruta = public_path() . '/' . Config::get("rutas.contenidos") . '/' . Config::get("rutas.tipo_productos") . '/';
				$IMAGE->move($ruta, $nuevoNombre);
				$pt->foto = $nuevoNombre;
				$pt->save();
			}
		}





		//Información almacenada
		$url = $url ."?salvado=y&" . str_random(16); //Le añadimos un string random al final del URL para evitar el cache y para volver la URL más difícil de leer.
		return Redirect::to( $url  );
	}

	/*
	 * El añadir tipo de producto solamente recibe el código y lo verifica para ver si ya existe. La ventaja es que no se crea hasta que el código sea realmente nuevo
	 * */
	public function anadirTipoProducto()
	{
		$url = \URL::previous();
		$url = explode("?", $url)[0]; //Removemos el query string en caso de que exista
		if (Input::get("codigo") != "") { //Verificamos si la categoría existe o es nueva
			$tp = \Tiqueso\tipo_producto::where("codigo", Input::get("codigo"))->first();
		}

		if ($tp != null) {
			//Esto quiere decir que el codigo ya existe, entonces tenemos que devolver un error
			return Redirect::to($url)->withErrors(["El código del producto ya existe. No se puede crear otro tipo de producto con el mismo código"])->withInput();
		}

		/*
		 * Creamos el nuevo tipo con el código y el resto de campos vacíos
		 * */
		$tp = new \Tiqueso\tipo_producto;
		$tp -> codigo 			= Input::get("codigo");
		$tp -> nombre 			= "Tipo de Producto Nuevo";
		$tp -> foto 			= "";
		$tp -> detalle 			= "";
		$tp -> caracteristicas 	= "";
		$tp -> vida_util 		= "";
		$tp -> created_at 		= new \DateTime();
		$tp -> updated_at 		= new \DateTime();

		$tp -> save();

		return Redirect::to("/admin_productos/modificar_tipo/" . $tp -> codigo);
	}

	/*Función que se encarga únicamente de borrar un tipo de producto*/
	public function borrar_tipo($usuario){
		$id = Request::segment(3);
		$cat = \Tiqueso\tipo_producto::where("codigo",$id);
		if($cat != null) $cat->delete(); //Borramos solamente si no es nulo
		return Redirect::to("/admin_productos/tipos"); //Redirigimos de nuevo a la página de categorías
	}

	/*
	 * Esta función muestra la página de registro de un producto nuevo.
	 * */

	public function registrarProducto($usuario){
		$data["usuario"] = $usuario;

                $tipos_productos = array() ;
                foreach( \Tiqueso\tipo_producto::all('codigo','nombre','vida_util')  as $tipo_producto){
                    $tipos_productos [ $tipo_producto->codigo ]["nombre"] = $tipo_producto-> nombre;
                    $tipos_productos [ $tipo_producto->codigo ]["vida_util"]= $tipo_producto-> vida_util;
                }
              //  var_dump( $data["tipo_productos"] );
                $data[ "tipos_productos" ] = $tipos_productos;
                $data["proveedores"] = \Tiqueso\proveedor::all('codigo','nombre');
		return view('admin_productos/registrar_producto')->with($data);
	}

	/*
	 * Esta función muestra la página de ingreso de producto en lista.
	 * */

	public function registrarIngreso($usuario){
		$data["usuario"] = $usuario;

		$id = Request::segment(3);
		$registro = \Tiqueso\registro_producto::find($id);

		if($registro == null){ //Creamos un nuevo registro para iniciar
			$registro = new \Tiqueso\registro_producto();
			$registro -> iniciado = new \DateTime();
			$registro -> usuario = $usuario->id;
			$registro -> save();
			return Redirect::to("/admin_productos/registrar_ingreso/".$registro->id);
		}
		if($registro->finalizado != ""){
			Comunes::enviar404();
		}

		$tipos_productos = array() ;
		foreach( \Tiqueso\tipo_producto::all('codigo','nombre','vida_util')  as $tipo_producto){
			$tipos_productos [ $tipo_producto->codigo ]["nombre"] = $tipo_producto-> nombre;
			$tipos_productos [ $tipo_producto->codigo ]["vida_util"]= $tipo_producto-> vida_util;
		}
		//  var_dump( $data["tipo_productos"] );
		$data[ "tipos_productos" ] = $tipos_productos;
		$data[ "registro" ] = $registro;
		$data["proveedores"] = \Tiqueso\proveedor::all('codigo','nombre');
		return view('admin_productos/registrar_ingreso')->with($data);
	}


	public function registrarIngresoAjax($usuario){

		$respuesta = new \App\clases\RespuestaAjax("RegistrarIngreso");


		$id = Request::segment(3);
		$registro = \Tiqueso\registro_producto::find($id);
		if($registro == null){
			$respuesta ->establecerErrores("10","Registro inexistente");
		}else{
			$registro->formulario = serialize(Input::all());
			if(Input::get("proveedor") != ""){
				$proveedor = \Tiqueso\proveedor::find( Input::get("proveedor") );
				if($proveedor != null){
					$registro -> proveedor = $proveedor->codigo;
					$registro -> proveedor_nombre = $proveedor->nombre;
				}
			}
			if(Input::get("detalle") != ""){
				$registro -> detalle = Input::get("detalle");
			}
			$registro -> save();
		}

		$respuesta -> setRespuesta(["Almacenado completado"]);


		return $respuesta->generarEstructura();

	}


	/*
	 * Esta función almacena un producto por medio de post.
	 * */
	public function salvarProducto($usuario){

		//Primero es necesario validar todos los campos.
		$url = \URL::previous();
		$url = explode("?", $url)[0]; //Removemos el query string en caso de que exista
		$pt = null;

		$rules = array(
			'proveedor' 		=> Comunes::reglas('textogenerico', true,'exists:proveedores,codigo'),
			'tipo_producto'		=> Comunes::reglas('textogenerico', true, 'exists:tipo_productos,codigo'),
			'tanda' 			=> Comunes::reglas('numero', true),
			'vencimiento' 		=> Comunes::reglas('fecha', true),
			'unidades' 			=> Comunes::reglas('numero_libre', false),
			'humedad' 			=> Comunes::reglas('numero_libre', false),
		);
		$validador = Validator::make(Input::all(), $rules);

		if ($validador->fails()) {
			return Redirect::to($url)->withErrors($validador)->withInput();;
		}

		$proveedor = \Tiqueso\proveedor::where("codigo",Input::get("proveedor"))->first();

		$producto = new \Tiqueso\producto(); //Creamos el nuevo objeto de producto


		$producto -> codigo_tipo		=		Input::get('tipo_producto');
		$producto -> codigo_proveedor	=		Input::get('proveedor');
		$producto -> nombre_proveedor	=		$proveedor->nombre; //Esto lo estamos almacenando como un registro histórico en caso de que el proveedor se elimine.
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
		$producto -> registrado			=		new \DateTime();
		$producto -> modificado			=		new \DateTime();

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

		return Redirect::to('admin_productos/ver');

	}

	public function verProductos($usuario){
		$data["usuario"] = $usuario;
		$data["productos"] 	=
							\Tiqueso\producto::select('productos.*','usuarios.nombre AS usuario_nombre','usuarios.apellido AS usuario_apellido','usuarios.correo AS usuario_correo','tipo_productos.nombre AS nombre_tipo')
								->leftJoin('usuarios', 'usuarios.id', '=', 'productos.creado_por')
								->leftJoin('tipo_productos', 'productos.codigo_tipo', '=', 'tipo_productos.codigo')
								->where( "productos.estado" , "1" )
								->where('productos.borrado',0)
								-> get();
		return view('admin_productos/ver')->with($data);
	}

	/*
	 * Esta función recopila y muestra la ficha de un producto. Está basado en la pagina suministrada por Tiqueso.
	 * */
	public function fichaProducto($usuario){
		$data["usuario"] = $usuario;
		$codigo = Request::segment(3); //Se obtiene el valor que viene en la URL

		$producto = \Tiqueso\producto::where('codigo',$codigo)->first();
		if($producto == null){ //Si no encontramos el producto, entonces enviamos la pagina de error para producto no encontrado
			return view('admin_productos/no_encontrado')->with($data);
		}
		$data['producto'] = $producto;
		return view('admin_productos/ficha')->with($data);
	}

	/*
	 * Esta función por el momento desactiva un producto para "sacarlo" de la planta
	 * */
	public function sacarProducto($usuario){
		$id = Request::segment(3);
		if($id != ""){
			$producto = producto::find($id);
			if($producto != null){
				$producto->modificado = new \DateTime();
				$producto->estado=0;
				$producto->save();
			}
		}
		return Redirect::to('/admin_productos/ver?sacado=y');
	}
	/*
	 * Esta función es la que se encarga de buscar productos por código
	 * */
	public function buscarProductos($usuario){
		$data["usuario"] = $usuario;
		$productos = [];
		if(Input::get('codigo') != ""){
			$productos = \Tiqueso\producto::where('codigo','LIKE','%'.Input::get('codigo').'%')->get();
		}
		$data["productos"] = $productos;
		return view('admin_productos/buscar')->with($data);

	}

	public function cambiarUbicacion($usuario){
		$data["usuario"] = $usuario;
		$codigo = Request::segment(3); //Se obtiene el valor que viene en la URL

		$producto = \Tiqueso\producto::where('codigo',$codigo)->first();
		if($producto == null){ //Si no encontramos el producto, entonces enviamos la pagina de error para producto no encontrado
			return view('admin_productos/no_encontrado')->with($data);
		}
		$data['producto'] = $producto;

		if((int)\Input::get('almacenaje') > 0){ //Podemos cambiar el almacenaje
			$nuevo_almacenaje = (int)\Input::get('almacenaje');
			$almacenaje = \Tiqueso\Almacenaje::find($nuevo_almacenaje);
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

		return Redirect::to('admin_productos/ficha_producto/'.$producto->codigo);
	}

	public function salvarRegistrarIngreso($usuario){

		$url = "/admin_productos/registrar_ingreso/";

		$id = Request::segment(3);
		$url .= $id;
		$registro_producto = registro_producto::find($id);
		if($registro_producto == null){
			return Redirect::to($url)->withErrors(["Registro de producto inexistente"])->withInput();
		}

		if( count(Input::get("tipo_producto")) !=  count(Input::get("lote")) || count(Input::get("lote")) != count(Input::get("vencimiento"))   ||  count(Input::get("vencimiento")) != count(Input::get("unidades"))  ){
			return Redirect::to($url)->withErrors(["Error en los datos de los productos"])->withInput();
		}

		$proveedor = proveedor::find(Input::get("proveedor"));
		if($proveedor == null){
			return Redirect::to($url)->withErrors(["Proveedor Inválido"])->withInput();
		}


		$registro_producto -> finalizado = new \DateTime();
		$registro_producto -> detalle = Input::get("detalle");
		$registro_producto -> proveedor = Input::get("proveedor");
		$registro_producto -> proveedor_nombre = $proveedor->nombre;

		$productos_final = [];

		foreach((array)Input::get("tipo_producto") AS $key => $value){
			$codigo = Input::get("tipo_producto")[$key] . $proveedor->codigo . Input::get("lote")[$key];
			if(!isset($productos_final[$codigo])){
				$productos_final[$codigo]["unidades"] = (float)0.0;
				$productos_final[$codigo]["vencimiento"] = "";
			}
			$productos_final[$codigo]["unidades"] += (float)Input::get("unidades")[$key];
			$productos_final[$codigo]["vencimiento"] = Input::get("vencimiento")[$key];
			$productos_final[$codigo]["tipo"] = Input::get("tipo_producto")[$key];
			$productos_final[$codigo]["lote"] = Input::get("lote")[$key];
		}

		$registro_producto -> formulario = serialize($productos_final);
		$registro_producto -> save();

		foreach($productos_final AS $key => $p){
			$producto = new \Tiqueso\producto(); //Creamos el nuevo objeto de producto

			$producto -> codigo_tipo		=		$p["tipo"];
			$producto -> codigo_proveedor	=		Input::get('proveedor');
			$producto -> nombre_proveedor	=		$proveedor->nombre; //Esto lo estamos almacenando como un registro histórico en caso de que el proveedor se elimine.
			$producto -> dia_juliano		=		'';
			$producto -> tanda				=		$p["lote"];
			$producto -> obtenerCodigoFinal();
			$vencimiento = \DateTime::createFromFormat(config('region.formato_fecha'),$p["vencimiento"]);
			$producto -> vencimiento		=		$vencimiento;
			$producto -> unidades			=		$p["unidades"];
			$producto -> humedad			=		0;
			$producto -> detalle			=		Input::get('detalle');
			$producto -> estado				=		1;
			$producto -> creado_por			=		$usuario->id;
			$producto -> registrado			=		new \DateTime();
			$producto -> modificado			=		new \DateTime();
			$producto -> save(); //Salvamos la información

			$inventario = new \Tiqueso\inventario();
			$inventario -> usuario = $usuario->id;
			$inventario -> codigo = $p["tipo"];
			$inventario -> cantidad = (float)$p["unidades"];
			$inventario -> creado = new \DateTime();
			$inventario -> lotes_involucrados = $p["lote"];
			$inventario -> vencimientos_involucrados = $p["vencimiento"];
			$inventario -> detalle = "Aumento de inventario por medio del registro: " . $registro_producto->id . ' y con el proveedor: ' . $registro_producto->proveedor . ' :: ' . $registro_producto->proveedor_nombre;
			$inventario -> estado = 1;
			$inventario -> save();

		}

		return Redirect::to("/admin_productos/resumen_registro/".$registro_producto->id);


	}

	public function resumenRegistro($usuario){
		$data["usuario"] = $usuario;
		$id = Request::segment(3);
		$producto_registro = registro_producto::find($id);

		if( $producto_registro == null ){
			return Comunes::enviar404();
		}

		if($producto_registro->finalizado == ""){
			return Comunes::enviar404();
		}

		$data["producto_registro"] = $producto_registro;

		if(Input::get("t") == "pdf") {
			$pdf = \PDF::loadView('admin_productos.resumen_registro_pdf', $data);
			return $pdf->stream('resumen.pdf');
		}elseif(Input::get("t") == "pdfd"){
				$pdf = \PDF::loadView('admin_productos.resumen_registro_pdf', $data);
				return $pdf->download('resumen.pdf');
		}else{

			return view('admin_productos/resumen_registro')->with($data);
		}



	}


}
