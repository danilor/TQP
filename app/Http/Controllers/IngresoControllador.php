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
class IngresoControllador extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller is in charge to manage everything about the login, with this I mean login, forgot password,
	| recover, session and everything realated
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		//$this->middleware('guest');
	}

	/**
	 * Show the application login screen
	 *
	 * @return Response
	 */
	public function ingreso(){
		$data = [];
		if(Auth::check()){
			return Redirect::to("/");
		}
		return view('ingreso/ingreso')->with($data);
	}
	public function recordar(){
		$data = [];
		if(Auth::check()){
			return Redirect::to("/");
		}
		return view('ingreso/recordar')->with($data);
	}


	public function accion_ingresar(){
		if(Auth::check()){
			return Redirect::to("/");
		}

		$url_original = "/";
		if(Request::input("url") != null && Request::input("url") != ""){
			$url_original = Request::input("url");
		}
		$rules = array(
			'usuario'              		=>  Comunes::reglas("usuario", true),
			'contrasena'              	=>  Comunes::reglas("contrasena", true),
		);
		// run the validation rules on the inputs from the form
		$validador = Validator::make(Input::all(), $rules);
		// if the validator fails, redirect back to the form
		if ($validador->fails()) {
			return Redirect::to('/ingresar')
				->withErrors($validador) // devolvemos los errores al formulario
				->withInput(Input::except('contrasena')); // devolvemos todo excepto la contraseña
		} else {
			$recordar = false;
			$r = Input::get('recordar');
			if(($r)=="y"){
				$recordar = true;
			}
			// creamos nuestro objeto de usuario para validarlo e
			// intenemos hacer el ingreso

			$usuario = ['usuario' => Input::get('usuario'), 'password' => Input::get('contrasena'),"activo"=>1];
			if (Auth::attempt($usuario,$recordar)) {
				return Redirect::to($url_original);
			} else {
				return Redirect::to('/ingresar?e')->withInput(Input::except('password','_token')); // Lo devolvemos con el error de que el usuario no existe
			}
		}
	}

	/*
	 * Esta función va a generar todo el proceso para el empezar los pasos para recuperar la contraseña
	 * */
	public function accion_recordar(){
		if (Auth::check()) {
			return Redirect::to("/");
		}
		$url_original = "/";
		if (Request::input("url") != null && Request::input("url") != "") {
			$url_original = Request::input("url");
		}
		$rules = array(
			'correo' => Comunes::reglas("correo", true),
		);
		// Tenemos que validar todo antes de que podamos continuar.
		$validador = Validator::make(Input::all(), $rules);
		// if the validator fails, redirect back to the form
		if ($validador->fails()) {
			return Redirect::to('/recordar')
				->withErrors($validador); // Devolvemos los errores
		} else {
			$usuario = \Tiqueso\usuario::where("correo",Input::get("correo"))->where("activo",1)->first();
			if ($usuario != null) {
				//Primero generamos y obtenemos el código con el que vamos a trabajar
				$codigo = Usuario::registrarRecuperarContrasena($usuario->id);
				//Ahora generamos el correo. Aunque no se envíe inmediatamente, hay un proceso existente que lo envía luego.
				$url = Request::root() . "/recobrar/$codigo";

				$cuerpo = "
					<p>Este correo le ha sido enviado porque se ha solicitado un proceso de recuperación de contraseña. Si usted no ha solicitado este proceso por favor hacer caso omiso a este mensaje.</p>
					<p>Para recuperar y reestablecer su contraseña por favor hacer clic al siguiente vínculo:</p>
					<ul>
						<li><a href='$url'>$url</a></li>
					</ul>
					<p>Si al hacer clic no se abre su navegador, por favor copiar el enlace y pegarlo directamente en su navegador para poder acceder al proceso indicado.</p>
					<p>Si tiene alguna duda o consulta puede contactarnos mediante nuestro sistema de <i>CONTACTO</i> y le atenderemos lo más pronto posible.</p>
				";

				Correo::generarCorreo("Recuperación de Contraseña","basica",$usuario->correo,"$usuario->nombre $usuario->apellido",$cuerpo);
				//Con el correo generado solo queda esperar que el proceso prosiga su camino automáticamente

			}

			return Redirect::to("/ingresar?snd");
		}
	}


	/*
	 * Función para ejecutar el deslogueo
	 * */
	public function accion_salir(){
		Auth::logout();
		\Session::flush();
		return Redirect::to("/");
	}


	/*
	public function recover(){
		Auth::logout();
		$data = array();
		$token = Request::segment(2);
		$tokenValid = Login::checkUserToken($token);

		$data["title"] = Str::title(trans('messages.recover'));
		$data["button"] = Str::title(trans('messages.log-in'));
		$data["user"] = Str::title(trans('messages.username'));
		$data["password"] = Str::title(trans('messages.password'));
		$data["validToken"] = $tokenValid;
		return view('login.recover')->with($data);
	}

	public function doRecover(){
		Auth::logout();
		\Session::flush();
		$data = array();
		$token = Request::segment(2);
		$tokenValid = Login::checkUserToken($token);

		if(!$tokenValid){
			return Redirect::to(Request::fullUrl())->withErrors([ucfirst(trans('messages.forgot_password_recover_bad'))]);
		}
		$rules['password']              	=  Common::getValRule("password", true, 'confirmed');

		$validator = Validator::make(Input::all(), $rules);
		if ($validator -> fails()){
			return Redirect::to(Request::fullUrl())->withErrors($validator);
		}
		//if everything is fine, lets update the user

		$id = Login::getUserIdByToken($token);
		$data["password"] = Hash::make(Input::get("password"));


		GUsers::updateUser($id,$data);
		Login::closeAllRecoversByUser($id);
		Logs::saveLog("users","recover","password",$id);

		return Redirect::to("/login?chan");
	}

	//This function is suppose to get the login valid or not, and if valid, then return to the original screen. If not, then show the error


	}


*/

}
