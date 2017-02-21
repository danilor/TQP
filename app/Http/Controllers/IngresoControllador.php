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


	public function __construct(){
		//$this->middleware('guest');
	}

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

	private function guardar_registro($estado,$usuario,$uid = null,$lon = null,$lat = null){
		\DB::table('registro_ingreso')->insert([
			'usuario'			=>		$usuario,
			'usuario_id'		=>		$uid,
			'fecha'				=>		new \DateTime(),
			'estado'			=>		$estado,
			'lat'				=>		$lat,
			'lon'				=>		$lon,
			'ip'				=>		Request::ip(true),

		]);
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
			$this->guardar_registro(0,Input::get('usuario'),null,Input::get('geo_lon'),Input::get('geo_lat'));
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
				$this->guardar_registro(1,Input::get('usuario'),null,Input::get('geo_lon'),Input::get('geo_lat'));
                            if( Request::segment(1) != "ingresar" ) // Si la solicitud no viene de la vista de ingresar entonces enviar a la url original
				return Redirect::to( $url_original );
                            else
                                return Redirect::to( "/admin_general" );//Redirigir la vista de ingresar al admin general
			} else {
				$this->guardar_registro(0,Input::get('usuario'),null,Input::get('geo_lon'),Input::get('geo_lat'));
				return Redirect::to('/ingresar?e')->withInput(Input::except('contrasena','_token')); // Lo devolvemos con el error de que el usuario no existe
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
				Usuario::enviarContraseña($usuario);
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


	//Esta función va a mostrar la pantalla de recobrar contraseña. Si el código es inválido o inexistente muestra un error.
	public function recobrar(){
		$data = [];
		if(Auth::check()){
			return Redirect::to("/");
		}

		$codigo = Request::segment(2);
		$data["codigo"] = $codigo;
		$tiempoValido = new \DateTime();
		$intervalo = new \DateInterval("PT2H");
		$intervalo -> h = 2;
		$tiempoValido -> sub($intervalo);

		$data["valido"] = false;
		$r = DB::table("recuperar_contrasenas")
					->where("estado",1)
					->where("created_at",">",$tiempoValido)
					->where("codigo",$codigo)
					->first();
		if($r != null){
			$data["valido"] = true;
		}

		return view('ingreso/recobrar')->with($data);
	}

	public function accion_recobrar(){
		if (Auth::check()) {
			return Redirect::to("/");
		}
		$url_original = "/";
		if (Request::input("url") != null && Request::input("url") != "") {
			$url_original = Request::input("url");
		}
		$codigo = Request::segment(2);
		$data["codigo"] = $codigo;
		$tiempoValido = new \DateTime();
		$intervalo = new \DateInterval("PT2H");
		$intervalo -> h = 2;
		$tiempoValido -> sub($intervalo);
		$r = DB::table("recuperar_contrasenas")
			->where("estado",1)
			->where("created_at",">",$tiempoValido)
			->where("codigo",$codigo)
			->first();
		if($r == null){
			return Comunes::enviar404();
		}

		$rules = array(
			'contrasena' 				=> Comunes::reglas("contrasena", true, "confirmed"),
			'contrasena_confirmation' 	=> Comunes::reglas("contrasena", true),
		);
		// Tenemos que validar todo antes de que podamos continuar.
		$validador = Validator::make(Input::all(), $rules);
		//dd($validador);
		// if the validator fails, redirect back to the form
		if ($validador->fails()) {
			return Redirect::to('/recobrar/'.$codigo)
				->withErrors($validador); // Devolvemos los errores
		} else {

			$usuario = \Tiqueso\usuario::where("id",$r->id_usuario)->where("activo",1)->first();
			if($usuario == null){
				return Comunes::enviar404();
			}
			DB::table("usuarios")->where("id",$usuario->id)->update(["password"=>bcrypt(Input::get('contrasena'))]);

			$cuerpo = "
					<p>Su contraseña ha sido cambiada exitosamente. Si usted no ha realizado ningún cambio de contraseña por favor comuníquese con nosotros lo antes posible.</p>
					<p>Si tiene alguna duda o consulta puede contactarnos mediante nuestro sistema de <i>CONTACTO</i> y le atenderemos lo más pronto posible.</p>
				";
			Correo::generarCorreo("Contraseña Cambiada","basica",$usuario->correo,"$usuario->nombre $usuario->apellido",$cuerpo);
			return Redirect::to("/ingresar?new");
		}
	}

}
