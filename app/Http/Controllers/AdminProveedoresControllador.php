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
class AdminProveedoresControllador  extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|ver_todos' =>  'verProveedores',
                'get|borrar_proveedor' =>  'borrarProveedor',
		'get|modificar_proveedor' => 'modificarProveedor',
		'post|salvar_informacion_de_proveedor' =>'salvarInformacionDeProveedor'
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
	public function verProveedores($usuario){
		$data["usuario"] = $usuario;
		return view('admin_proveedores/ver')->with($data);
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
	public function borrarProveedor($usuario){
		$codigo = Request::segment(3);
		$p = \Tiqueso\proveedor::where("codigo","$codigo"); //Busca al proveedor con el codigo
                $p ->delete();
		return Redirect::to("admin_proveedores/ver_todos");
	}

	/*
	 * Estas función muestra la página de modificar usuario. Va a contener mucha información del mismo perfil pero añadiendo ciertos
	 * campos especiales que solamente una persona con permisos podría modificar, por ejemplo grados académicos entre otros.
	 * */
	public function modificarProveedor($usuario){
		$id = Request::segment(3);
		$p = \Tiqueso\proveedor::where("codigo",$id)->first(); //Busca al proveedor con el ID
		if($p == null ){ //Es nulo! Volvamos a la lista de proveedores porque posiblemente sea un error.
			return Redirect::to("admin_proveedores/ver_todos?modificar=proveedor_no_encontrado&".str_random(16)); //añadimos un string aleatorio para dificultar la lectura del URL.
		}
		//Podemos mostrar la página
		$data["usuario"] = $usuario;
		$data["p"] = $p; //Este es el proveedor que estamos modificando,
		return view('admin_proveedores/modificar_proveedor')->with($data);
	}

	/*
	 * Este proceso es el encargado de salvar la información del usuario. Debería de funcionar tanto para usuarios nuevos como para usuarios ya existentes.
	 * */
	public function salvarInformacionDeProveedor($usuario){

		$url = \URL::previous();
		$url = explode("?",$url)[0]; //Removemos el query string en caso de que exista

		if( Input::get("codigo_original") != ""){ //Verificamos si el proveedor existe o es nuevo
			$p = \Tiqueso\proveedor::where("codigo",Input::get("codigo_original"))->first();
			if($p == null){
				return Redirect::to($url) -> withErrors(["Proveedor invalido"])->withInput();
			}
		}else{
			$p = new \Tiqueso\proveedor();
		}
		$rules = array(
			'codigo' 		=> Comunes::reglas('textogenerico', true),
			'nombre' 		=> Comunes::reglas('nombre', true),
		);
                if( strlen( Input::get("codigo") )!== 2 ){ // Si el codigo de proveedor es distinto a 2 digitons entonces devolver error
                    return Redirect::to($url) -> withErrors(["El código [".Input::get("codigo")."] es distinto de 2 digitos. El codigo debe usar 2 digitos."])->withInput();   
                }
		$validador = Validator::make(Input::all(), $rules);
		if ($validador -> fails()) {
			return Redirect::to($url) -> withErrors($validador)->withInput();
                }
		//we have to check if the email already exists
		/*if(		Input::get("correo")  != $p->correo ){
			//he is trying to change its email
			if(Input::get("codigo") != ""){
				$r = \Tiqueso\proveedor::where("correo",Input::get("correo"))->where("codigo","<>",$p->codigo)->first();
			}else{
				$r = \Tiqueso\proveedor::where("correo",Input::get("correo"))->first();
			}

			if($r != null ){
				//There is another use with that email
				return Redirect::to($url) -> withErrors(["Correo [".Input::get("correo")."] ya está siendo utilizado por otro proveedor"])->withInput();
			}
		}*/
		//Es momento de salvar la información

                
		$p->codigo = Input::get("codigo");
		$p->nombre = Input::get("nombre");
		$p->detalle = Input::get("detalle");
		$p->correo = Input::get("correo");
                $p->direccion = Input::get("direccion");
                $p->telefono = Input::get("telefono");
                $p->updated_at = new \DateTime(); //Actualizamos la fecha de la actualización

		$p->save(); //Salvamos la información

		// Luego de salvado (primero salvamos en caso de que sea un nuevo usuario porque necesitamos el ID
		// buscamos y almacenamos la imagen (si existe) y la asignamos
		/*if(Input::file("image") != null) {
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
                */

		//Información almacenada
		//$url = "/admin_proveedores/modificar_proveedor/".$p->codigo."?salvado=y&" . str_random(16); //Le añadimos un string random al final del URL para evitar el cache y para volver la URL más difícil de leer.
                $url ="$url?salvado=y";//Agregado el resultado de salvado
		return Redirect::to( $url  );
	}















}
