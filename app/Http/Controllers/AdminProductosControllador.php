<?php namespace Tiqueso\Http\Controllers;
use Illuminate\Support\Str;
use Request;
use Input;
use Redirect;
use Auth;
use Tiqueso\categoria_producto;
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
		// buscamos y almacenamos la imagen (si existe) y la asignamos
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

}
