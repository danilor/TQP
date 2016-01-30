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
class PerfilControlador extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|'                      	=>  'tablero||',
		'get|informacion_basica'       	=>  'informacion_basica||',

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
			$g = explode('|',$this->reglas[$urlrule]);
			$functionname = @$g[0];
			$params = @$g[1];
			return $this->$functionname($usuario);
		}else{
			return Common::send404('Unkown Request'); //We are not sure what type of request was this, so we throw a 404 error.
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

}
