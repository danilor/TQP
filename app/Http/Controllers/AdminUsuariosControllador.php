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
class AdminUsuariosControllador  extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|ver_todos'                      	=>  'verUsuarios',
		'get|directorio'                      	=>  'verDirectorio',
		'get|borrar_usuario'                   	=>  'borrarUsuario',
		'get|modificar_usuario'					=>	'modificarUsuario',
		'post|salvar_informacion_de_usuario'	=>	'salvarInformacionDeUsuario',
		'get|permisos'                      	=>  'verPermisos',
		'post|salvar_permiso'					=>	'salvarPermiso',
		'get|borrar_permiso'                   	=>  'borrarPermiso',
		'get|roles'                      		=>  'verRoles',
		'post|salvar_rol'						=>	'salvarRol',
		'get|modificar_rol'						=>	'modificarRol',
		'get|borrar_rol'						=>	'borrarRol',

	);

	public function __construct(){
		//$this->middleware('guest');
	}

	public function principal(){
		$usuario = Auth::user();
		if(!Auth::check()){
			return Redirect::to('/ingresar?accesso&url='.Request::url());
		}
		if(!Auth::user()->puede(["administrar_usuarios"])){
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
	}

	/*
	 * Esta función se encarga solamente de mostrar los usuarios activos actualmente en formato de directorio. No va a incluir el formulario de añadir
	 * */
	public function verUsuarios($usuario){
		$data["usuario"] = $usuario;
		return view('admin_usuarios/ver')->with($data);
	}

	public function verDirectorio($usuario){
		$data["usuario"] = $usuario;
		$data["lista_usuarios"] = [];
		if(Request::segment(3) == ""){
			$data["lista_usuarios"] = \Tiqueso\usuario::where("activo",1)->orderBy("nombre","asc")->get();
		}else{
			$data["lista_usuarios"] = \Tiqueso\usuario::where("activo",1)->where("nombre","like",Request::segment(3)."%")->orderBy("nombre","asc")->get();
		}
		return view('admin_usuarios/directorio')->with($data);
	}

	/*
	 * Esta función verificar que el usuario exista y lo cambia de estado a 0 para no borrarlo realmente. Luego vuelve al listado
	 * */
	public function borrarUsuario($usuario){
		$id = Request::segment(3);
		$u = \Tiqueso\usuario::find($id); //Busca al usuario con el ID
		if($u != null ){ //No es nulo, podemos borrar (desactivar)
			$u->activo = 0;
			$u->save();
		}
		return Redirect::to("admin_usuarios/ver_todos");
	}

	/*
	 * Estas función muestra la página de modificar usuario. Va a contener mucha información del mismo perfil pero añadiendo ciertos
	 * campos especiales que solamente una persona con permisos podría modificar, por ejemplo grados académicos entre otros.
	 * */
	public function modificarUsuario($usuario){
		$id = Request::segment(3);
		$u = \Tiqueso\usuario::where("activo",1)->where("id",$id)->first(); //Busca al usuario con el ID
		if($u == null ){ //Es nulo! Volvamos a la lista de usuarios porque posiblemente sea un error.
			return Redirect::to("admin_usuarios/ver_todos?modificar=usuario_no_encontrado&".str_random(16)); //añadimos un string aleatorio para dificultar la lectura del URL.
		}
		//Podemos mostrar la página
		$data["usuario"] = $usuario;
		$data["u"] = $u; //Este es el usuario que estamos modificando, y no el que tenemos la sesión abierta (Aunque puede ser el mismo en ciertos momentos).
		return view('admin_usuarios/modificar_usuario')->with($data);
	}

	/*
	 * Este proceso es el encargado de salvar la información del usuario. Debería de funcionar tanto para usuarios nuevos como para usuarios ya existentes.
	 * */
	public function salvarInformacionDeUsuario($usuario){

		$url = \URL::previous();
		$url = explode("?",$url)[0]; //Removemos el query string en caso de que exista

		if(Input::get("id") != ""){ //Verificamos si el usuario existe o es nuevo
			$u = \Tiqueso\usuario::where("activo",1)->where("id",Input::get("id"))->first();
			if($u == null){
				return Redirect::to($url) -> withErrors(["Usuario inválido"])->withInput();;
			}
		}else{
			$u = new \Tiqueso\usuario();
		}
		$rules = array(
			'cedula' 		=> Comunes::reglas('textogenerico', true),
			'nombre' 		=> Comunes::reglas('nombre', true),
			'apellido' 		=> Comunes::reglas('apellido', true),
			'correo' 		=> Comunes::reglas('correo', true),
			'apodo' 		=> Comunes::reglas('nombre', false),
			'sexo' 			=> Comunes::reglas('textogenerico_min', true),
			'direccion' 	=> Comunes::reglas('textogenerico_min', true),
			'direccion2' 	=> Comunes::reglas('textogenerico_min', false),
			'caracteristicas'=> Comunes::reglas('textogenerico_min', false),
			'notas' 		=> Comunes::reglas('textogenerico_min', false),
			'educacion' 	=> Comunes::reglas('textogenerico_min', false),
			'certificaciones'=> Comunes::reglas('textogenerico_min', false),
		);
		$validador = Validator::make(Input::all(), $rules);
		if ($validador -> fails()) {
			return Redirect::to($url) -> withErrors($validador)->withInput();;
		}
		//we have to check if the email already exists
		if(		Input::get("correo")  != $u->correo ){
			//he is trying to change its email
			if(Input::get("id") != ""){
				$r = \Tiqueso\usuario::where("correo",Input::get("correo"))->where("activo",1)->where("id","<>",$u->id)->first();
			}else{
				$r = \Tiqueso\usuario::where("correo",Input::get("correo"))->where("activo",1)->first();
			}

			if($r != null ){
				//There is another use with that email
				return Redirect::to($url) -> withErrors(["Correo [".Input::get("correo")."] ya está siendo utilizado por otro usuario"])->withInput();;
			}
		}
		//Es momento de salvar la información


		$u->cedula = Input::get("cedula");
		$u->nombre = Input::get("nombre");
		$u->apellido = Input::get("apellido");
		$u->correo = Input::get("correo");
		$u->apodo = Input::get("apodo");
		$u->sexo = Input::get("sexo");
		$u->direccion = Input::get("direccion");
		$u->direccion2 = Input::get("direccion2");
		$u->caracteristicas = Input::get("caracteristicas");
		$u->notas = Input::get("notas");
		$u->educacion = Input::get("educacion");
		$u->certificaciones = Input::get("certificaciones");
		$u->updated_at = new \DateTime(); //Actualizamos la fecha de la actualización

		$u->save(); //Salvamos la información

		// Luego de salvado (primero salvamos en caso de que sea un nuevo usuario porque necesitamos el ID
		// buscamos y almacenamos la imagen (si existe) y la asignamos
		if(Input::file("image") != null) {
			$IMAGE = Input::file("image");
			$nuevoNombre = "USUARIO_" . $u->id . "_" . date("Ymd") . str_random(8) . '.' . $IMAGE->getClientOriginalExtension(); //Creamos el nuevo nombre con que lo vamos a almacenar

			if ((int)$IMAGE->getClientSize() > (int)Config::get("archivos.tamano_maximo")) {
				return Redirect::to($url)->withErrors(["Imágen supera el tamaño máximo"])->withInput();;
			}
			//dd(base_path() . '/public/'.Config::get("paths.UPLOADS").'/'.Config::get("paths.USERS").'/'. $imageName);
			$ruta = public_path() . '/' . Config::get("rutas.contenidos") . '/' . Config::get("rutas.usuarios") . '/';
			$IMAGE->move($ruta, $nuevoNombre);
			$u->foto = $nuevoNombre;
			$u->save();
		}

		//Ahora, tenemos que verificar los roles. Primero eliminamos todos los roles de usuario para asignar nuevos (si es que hay)
		DB::table("usuarios_roles") -> where("id_usuario",$u->id) -> delete();
		if(Input::get("roles") != null && is_array(Input::get("roles"))) foreach(Input::get("roles") AS $key => $value){
			DB::table("usuarios_roles") -> insertGetId(["id_rol"=>$value,"id_usuario"=>$u->id]);
		}

		//Por último verificamos la administración del sitio.
		if($usuario->esAdministrador()){
				if( Input::get("administrador") == "y" ){
					$u->super_administrador = 1;
				}else{
					$u->super_administrador = 0;
				}
				$u->save();
		}


		//Información almacenada
		$url = "/admin_usuarios/modificar_usuario/".$u->id."?salvado=y&" . str_random(16); //Le añadimos un string random al final del URL para evitar el cache y para volver la URL más difícil de leer.
		return Redirect::to( $url  );
	}

	/*
	 * Esta función solamente muestra la página de permisos
	 * */
	public function verPermisos($usuario){
		$data["usuario"] = $usuario;
		return view('admin_usuarios/permisos')->with($data);
	}

	/*
         * Este proceso es el encargado de salvar la información del permiso. Debería de funcionar tanto para permisos nuevos como para permisos ya existentes.
         * */
	public function salvarPermiso($usuario){
		$url = "admin_usuarios/permisos/";
		$url = explode("?",$url)[0]; //Removemos el query string en caso de que exista

		if(Input::get("id_permiso") != ""){ //Verificamos si el permiso existe o es nuevo
			$p = \Tiqueso\permiso::where("id",Input::get("id_permiso"))->first();
			if($p == null){
				return Redirect::to($url) -> withErrors(["Permiso Inválido"])->withInput();;
			}
		}else{
			$p = new \Tiqueso\permiso();
		}


		$rules = array(
			'nombre' 		=> Comunes::reglas('textogenerico', true),
			'alias' 		=> Comunes::reglas('textogenerico', true),
		);
		$validador = Validator::make(Input::all(), $rules);
		if ($validador -> fails()) {
			return Redirect::to($url) -> withErrors($validador)->withInput();;
		}

		//Es momento de salvar la información

		$p->nombre = Input::get("nombre");
		$p->alias = str_slug(Input::get("alias"),"_");
		$p->save();

		//Información almacenada
		$url = $url.$p->id."?salvado=y&" . str_random(16); //Le añadimos un string random al final del URL para evitar el cache y para volver la URL más difícil de leer.
		return Redirect::to( $url  );
	}

	/*
	 * Esta función verificar que el usuario exista y lo cambia de estado a 0 para no borrarlo realmente. Luego vuelve al listado
	 * */
	public function borrarPermiso($usuario){
		$id = Request::segment(3);
		$u = \Tiqueso\permiso::find($id); //Busca al permiso con el ID
		if($u != null ){ //No es nulo, podemos borrar
			$u->delete();
		}
		return Redirect::to("admin_usuarios/permisos");
	}

	/*
	 * Esta función solamente muestra la página de permisos
	 * */
	public function verRoles($usuario){
		$data["usuario"] = $usuario;
		return view('admin_usuarios/roles')->with($data);
	}

	/*
	 * Esta función va a salvar el rol. Debería de funcionar tanto para roles nuevos como para ya existentes
	 * */
	public function salvarRol($usuario){
		$url = \URL::previous();
		$url = explode("?",$url)[0]; //Removemos el query string en caso de que exista
		if(Input::get("id") != ""){ //Verificamos si el permiso existe o es nuevo
			$p = \Tiqueso\rol::where("id",Input::get("id"))->first();
			if($p == null){
				return Redirect::to($url) -> withErrors(["Rol Inválido"])->withInput();;
			}
		}else{
			$p = new \Tiqueso\rol();
		}
		$rules = array(
			'nombre' 		=> Comunes::reglas('textogenerico', true),
		);
		$validador = Validator::make(Input::all(), $rules);
		if ($validador -> fails()) {
			return Redirect::to($url) -> withErrors($validador)->withInput();;
		}
		//Es momento de salvar la información

		$p->nombre = Input::get("nombre");

		//Ahora revisamos los permisos
		if(  Input::get("permisos") != null && is_array(Input::get("permisos")) ){
				$p->permisos = implode( "," , Input::get("permisos") );
		}
		$p->save();
		//Información almacenada
		$url = $url."?salvado=y&" . str_random(16); //Le añadimos un string random al final del URL para evitar el cache y para volver la URL más difícil de leer.
		return Redirect::to( $url  );
	}

	/*
	 * Estas función muestra la página de modificar rol.
	 * */
	public function modificarRol($usuario){
		$id = Request::segment(3);
		$r = \Tiqueso\rol::where("id",$id)->first(); //Busca al rol con el ID
		if($r == null ){ //Es nulo! Volvamos a la lista de roles porque posiblemente sea un error.
			return Redirect::to("admin_usuarios/roles?modificar=usuario_no_encontrado&".str_random(16)); //añadimos un string aleatorio para dificultar la lectura del URL.
		}
		//Podemos mostrar la página
		$data["usuario"] = $usuario;
		$data["r"] = $r; //Este es el usuario que estamos modificando, y no el que tenemos la sesión abierta (Aunque puede ser el mismo en ciertos momentos).
		return view('admin_usuarios/modificar_rol')->with($data);
	}

	public function borrarRol($usuario){
		$id = Request::segment(3);
		$r = \Tiqueso\rol::where("id",$id)->first(); //Busca al rol con el ID
		if($r == null ){ //Es nulo! Volvamos a la lista de roles porque posiblemente sea un error.
			return Redirect::to("admin_usuarios/roles?modificar=usuario_no_encontrado&".str_random(16)); //añadimos un string aleatorio para dificultar la lectura del URL.
		}
		DB::table("usuarios_roles")->where("id_rol",$id)->delete();
		$r->delete();
		return Redirect::to("admin_usuarios/roles?borrado=y&".str_random(16));

	}

}
