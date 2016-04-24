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
use Image;


//This class will take care of the login information
class GeneralControllador  extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|foto_usuario'                      =>  'obtenerFotoUsuario',
		'get|foto_tipo_producto'                =>  'obtenerFotoTipoProducto',
	);

	public function __construct(){
		//$this->middleware('guest');
	}

	public function principal(){

		$segmento = strtolower(Request::segment(2)); //we get the section the user wants to access
		$request = strtolower(Request::getMethod());
		$urlrule = "$request|$segmento";
		if(isset($this->reglas[$urlrule])){
			$g = $this->reglas[$urlrule];
			return $this->$g();
		}else{
			return Comunes::enviar404(); //We are not sure what type of request was this, so we throw a 404 error.
		}
	}

	/*
	 * Esta función va a pedir la foto de un usuario y genera una imagen dependiendo de las dimensiones requeridas
	 * */
	public function obtenerFotoUsuario(){

		$id = Request::segment(3);
		if($id == ""){
			return "Sin usuario";
		}
		$u = \Tiqueso\usuario::find($id);
		if($u == null){
			return "Usuario Inválido";
		}
		$foto = public_path() . $u->obtenerFoto();

		$w = 300;
		$h = 300;

		if(Input::get("w") != "" && is_numeric(Input::get("w"))){ //Vemos si viene un ancho configurado
			$w = (int)Input::get("w");
		}
		if(Input::get("h") != "" && is_numeric(Input::get("h"))){ //vemos si viene un alto configurado
			$h = (int)Input::get("h");
		}
		$type = "fit";
		if(Input::get("type") != ""  ){ //vemos si viene un tipo configurado
			$type = (int)Input::get("type");
		}
		switch($type){
			case "fit":
				$img = Image::make($foto)->fit($w, $h);
				break;
			case "resize":
				$img = Image::make($foto)->resize($w, $h);
				break;
			default:
				$img = Image::make($foto)->fit($w, $h);
				break;
		}


		return $img->response('jpg');
	}

	public function obtenerFotoTipoProducto(){

		$id = Request::segment(3);
		if($id == ""){
			return "Sin código de producto";
		}
		$u = \Tiqueso\tipo_producto::where("codigo",$id)->first(); //Buscamos la primera concidencia del tipo de producto
		if($u == null){
			return "Código inválido";
		}
		$foto = public_path() . $u->obtenerFoto();

		$w = 300;
		$h = 300;

		if(Input::get("w") != "" && is_numeric(Input::get("w"))){ //Vemos si viene un ancho configurado
			$w = (int)Input::get("w");
		}
		if(Input::get("h") != "" && is_numeric(Input::get("h"))){ //vemos si viene un alto configurado
			$h = (int)Input::get("h");
		}
		$type = "fit";
		if(Input::get("type") != ""  ){ //vemos si viene un tipo configurado
			$type = (int)Input::get("type");
		}
		switch($type){
			case "fit":
				$img = Image::make($foto)->fit($w, $h);
				break;
			case "resize":
				$img = Image::make($foto)->resize($w, $h);
				break;
			default:
				$img = Image::make($foto)->fit($w, $h);
				break;
		}


		return $img->response('jpg');


	}

}
