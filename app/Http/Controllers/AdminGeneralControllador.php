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
class AdminGeneralControllador extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|'                      	=>  'tablero||',

	);

	public function __construct(){
		//$this->middleware('guest');
	}

	public function principal(){
		$data["usuario"] = Auth::user();
		if(!Auth::check()){
			return Redirect::to('/ingresar?accesso&url='.Request::url());
		}

		if(!Auth::user()->esAdministrador()){
			return Redirect::to('/ingresar?accesso&url='.Request::url());
		}
		return view('admin_general/tablero')->with($data);
	}

}
