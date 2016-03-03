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
class ProductosControllador extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|'                      	=>  'tablero',
		'get|categorias'                =>  'categorias',
		'get|borrar_categoria'          =>  'borrar_categoria',

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
		return Redirect::to("/productos/categorias"); //Redirigimos de nuevo a la página de categorías
	}

}
