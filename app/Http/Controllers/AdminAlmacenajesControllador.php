<?php namespace Tiqueso\Http\Controllers;
use Illuminate\Support\Str;
use Request;
use Input;
use Redirect;
use Auth;
use Validator;
use Config;
use Hash;
use Session;
use DB;
use App\clases\Comunes;
use App\clases\Usuario;
use App\clases\Correo;


//This class will take care of the login information
class AdminAlmacenajesControllador extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|ver'                      	=>  'verTodos',
		'get|salvar_almacenaje'			=>  'verSalvarAlmacenaje',
		'post|salvar_almacenaje'		=>  'salvarAlmacenaje',
		'get|borrar_almacenaje'			=>	'borrarAlmacenaje'

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

	public function borrarAlmacenaje($usuario){
		$id = Request::segment(3);
		$almacenaje = \Tiqueso\almacenaje::find($id);
		if($almacenaje != null){
			$almacenaje->borrado = 1;
			$almacenaje->borrado_por = $usuario->id;
			$almacenaje->save();
		}
		return Redirect::to("admin_almacenaje/ver");
	}

	public function verTodos($usuario){
		$data["usuario"] = $usuario;
		return view('admin_almacenaje/ver')->with($data);
	}

	public function verSalvarAlmacenaje($usuario){
		$data["usuario"] = $usuario;
		$almacenaje = null;
		if(Request::segment(3) != ""){
			$almacenaje = \Tiqueso\almacenaje::find(Request::segment(3));
		}
		$data['almacenaje'] = $almacenaje;
		return view('admin_almacenaje/modificar')->with($data);
	}

	public function salvarAlmacenaje($usuario){

		$url = \URL::previous();
		$url = explode("?",$url)[0]; //Removemos el query string en caso de que exista
		if( Input::get("id") != ""){ //Verificamos si el proveedor existe o es nuevo
			$p = \Tiqueso\almacenaje::where("id",Input::get("id"))->first();
			$p->modificado = new \DateTime();
			$p->modificado_por = $usuario->id;
			if($p == null){
				return Redirect::to($url) -> withErrors(["Proveedor invalido"])->withInput();
			}
		}else{
			$p = new \Tiqueso\almacenaje();
			$p->creado = new \DateTime();
			$p->creado_por = $usuario->id;
			$p->modificado = new \DateTime();
			$p->modificado_por = $usuario->id;
		}
		$rules = array(
			'nombre' 		=> Comunes::reglas('nombre', true),
			'placa' 		=> Comunes::reglas('textogenerico', false),
			'ubicacion' 	=> Comunes::reglas('textogenerico',false),
			'temperatura' 	=> Comunes::reglas('textogenerico',false),
			'tipo' 			=> Comunes::reglas('numero',true,'in:0,1'),
		);

		$validador = Validator::make(Input::all(), $rules);
		if ($validador -> fails()) {
			return Redirect::to($url) -> withErrors($validador)->withInput();
		}

		$p->nombre = Input::get("nombre");
		$p->ubicacion = Input::get("ubicacion");
		$p->temperatura = Input::get("temperatura");
		$p->placa = Input::get("placa");
		$p->tipo = Input::get("tipo");

		if( Input::get("principal") == "y" ){
			/**
			 * Tenemos que quitar de principal todos y poner este único como principal.
			 */
			 \Tiqueso\almacenaje::where("principal",1)->update(["principal" => 0]);
			 $p -> principal = 1;
			 $p -> save();
		}

		$p->save();

		$url ="/admin_almacenaje/ver?salvado=y";//Agregado el resultado de salvado
		return Redirect::to( $url  );

	}



}
