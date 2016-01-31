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
use Tiqueso\usuario;



//This class will take care of the login information
class PerfilControlador extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|'                      	=>  'tablero',
		'get|informacion_basica'       	=>  'informacion_basica',

		'post|salvar_informacion_basica'			=>		'salvarInformacionBasica'

	);

	public function __construct(){
		//$this->middleware('guest');
	}

	/*Esta función lee el URL a partir de "perfil" y ejecuta la función dependiendo de las reglas establecidas*/
	public function principal(){
		$usuario = Auth::user();
		if(!Auth::check()){
			return Redirect::to('/ingresar?accesso&url='.Request::url());
		}
		$segmento = strtolower(Request::segment(2)); //we get the section the user wants to access
		$request = strtolower(Request::getMethod());
		$urlrule = "$request|$segmento";
		if(isset($this->reglas[$urlrule])){
			$g = $this->reglas[$urlrule];
			return $this->$g($usuario);
		}else{
			return Comunes::enviar404(); //We are not sure what type of request was this, so we throw a 404 error.
		}

		return view('perfil/tablero')->with($data);
	}

	public function tablero($usuario){
		$data["usuario"] = $usuario;
		if(!Auth::check()){
			return Redirect::to('/ingresar?accesso&url='.Request::url());
		}
		return view('perfil/tablero')->with($data);
	}

	public function informacion_basica($usuario){
		$data["usuario"] = $usuario;
		if(!Auth::check()){
			return Redirect::to('/ingresar?accesso&url='.Request::url());
		}
		return view('perfil/informacion_basica')->with($data);
	}

	public function salvarInformacionBasica($usuario){
		$url = "/perfil/informacion_basica/";
		$rules = array(
			'cedula' 		=> Comunes::reglas('textogenerico', true),
			'nombre' 		=> Comunes::reglas('nombre', true),
			'apellido' 		=> Comunes::reglas('apellido', true),
			'correo' 		=> Comunes::reglas('correo', true),
			'apodo' 		=> Comunes::reglas('nombre', false),
			'sexo' 			=> Comunes::reglas('textogenerico_min', true),
			'direccion' 	=> Comunes::reglas('textogenerico_min', true),
			'direccion2' 	=> Comunes::reglas('textogenerico_min', false),


		);
		$validador = Validator::make(Input::all(), $rules);
		if ($validador -> fails()) {
			return Redirect::back() -> withErrors($validador);
		}
		//we have to check if the email already exists
		if(		Input::get("correo")  != $usuario->correo ){
			//he is trying to change its email
			$r = usuario::where("correo",Input::get("correo"));
			if($r !== false ){
				//There is another use with that email
				return Redirect::to($url) -> withErrors(["Correo [".Input::get("correo")."] ya está siendo utilizado por otro usuario"]);
			}
		}
		//Es momento de salvar la información

		$usuario->cedula = Input::get("cedula");
		$usuario->nombre = Input::get("nombre");
		$usuario->apellido = Input::get("apellido");
		$usuario->correo = Input::get("correo");
		$usuario->apodo = Input::get("apodo");
		$usuario->sexo = Input::get("sexo");
		$usuario->direccion = Input::get("direccion");
		$usuario->direccion2 = Input::get("direccion2");
		$usuario->updated_at = new \DateTime(); //Actualizamos la fecha de la actualización
		$usuario->save(); //Salvamos la información


		//Información almacenada
		$url = "/perfil/informacion_basica/"."?salvado=y";
		return Redirect::to( $url  );
		//return "All good";

	}

}
