<?php namespace Tiqueso\Http\Controllers;
use Illuminate\Support\Str;
use Request;
use Input;
use Redirect;
use Auth;
use Tiqueso\banner;
use Tiqueso\categoria_producto;
use Tiqueso\producto;
use Validator;
use Config;
use Hash;
use Session;
use DB;
use App\clases\Comunes;
use App\clases\Usuario;
use App\clases\Correo;


//This class will take care of the login information
class AdminContenidosControllador  extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|recetas'					=>	'mostrarRecetas',
		'get|borrar_receta'             =>  'borrarReceta',
		'get|salvar_receta'				=>	'mostrarSalvarReceta',
		'post|salvar_receta'			=>	'salvarReceta',
		'get|banners'					=>	'verBanners',
		'get|subir_banner'				=>	'subirBanners',
		'post|subir_banner'				=>	'salvarBanners',
		'get|borrar_banner'				=>	'borrarBanner',
		'get|actualizar_orden_banner'	=>	'actualizarOrdenBanner',

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

	/*
	 * Esta función muestra la lista de recetas
	 * */

	public function mostrarRecetas($usuario){
		$data["usuario"] = $usuario;
		return view('admin_contenidos/ver_recetas')->with($data);
	}


	/*
	 * Esta función verificar que el usuario exista y lo cambia de estado a 0 para no borrarlo realmente. Luego vuelve al listado
	 * */
	public function borrarReceta($usuario){
		$id = Request::segment(3);
		$u = \Tiqueso\receta::find($id); //Busca al usuario con el ID
		if($u != null ){ //No es nulo, podemos borrar (desactivar)
			$u->delete();
		}
		return Redirect::to("admin_contenidos/recetas");
	}

	public function mostrarSalvarReceta($usuario){
		$data["usuario"] = $usuario;
		if(Request::segment(3) != ""){
			$receta = \Tiqueso\receta::find(Request::segment(3));
			if($receta != null){
				$data['r'] = $receta;
			}
		}

		return view('admin_contenidos/modificar_receta')->with($data);
	}

	public function salvarReceta($usuario){
		$url = \URL::previous();
		$url = explode("?", $url)[0]; //Removemos el query string en caso de que exista
		$dated = new \DateTime(); //Obtenemos la fecha actual
		$rules = array(
			'nombre' 			=> Comunes::reglas('textogenerico', true),
			'receta' 			=> Comunes::reglas('textogenerico', true),
		);
		$validador = Validator::make(Input::all(), $rules);

		if ($validador->fails()) {
			return Redirect::to($url)->withErrors($validador)->withInput();
		}

		$receta = null;
		if(  Input::get('id')  != "" ){
			//Viene con un ID modificable
			$receta = \Tiqueso\receta::find(Input::get('id'));
			if($receta != null){
				$receta -> modificado = $dated;
				$receta -> modificado_por = $usuario->id;
			}else{
				$receta = new \Tiqueso\receta();
				$receta -> modificado = $dated;
				$receta -> creado = $dated;
				$receta -> creado_por = $usuario->id;
			}
		}else{
			$receta = new \Tiqueso\receta();
			$receta -> modificado = $dated;
			$receta -> creado = $dated;
			$receta -> creado_por = $usuario->id;
		}

		$receta -> nombre = Input::get('nombre');
		$receta -> contenido = Input::get('receta');

		if(is_array(Input::get('productos_asignados'))){
			$receta -> productos_relacionados = implode(',',Input::get('productos_asignados'));
		}

		$receta->save();

		return Redirect::to('/admin_contenidos/salvar_receta/'.$receta->id.'?salvado=y');

	}

	public function verBanners($usuario){
		$data["usuario"] = $usuario;
		return view('admin_contenidos/banners')->with($data);
	}

	public function subirBanners($usuario){
		$data["usuario"] = $usuario;
		return view('admin_contenidos/subir_banner')->with($data);
	}

	public function salvarBanners($usuario){

		$url = \URL::previous();
		$url = explode("?", $url)[0]; //Removemos el query string en caso de que exista


		$codigo = date('Ymd').str_random(8);

		if(Input::file("image") != null) {

			$banner = new \Tiqueso\banner();
			$banner -> creado_por = $usuario->id;


			$IMAGE = Input::file("image");
			$nuevoNombre = "BANNER_" . $codigo . '.' . $IMAGE->getClientOriginalExtension(); //Creamos el nuevo nombre con que lo vamos a almacenar
			if ((int)$IMAGE->getClientSize() > (int)Config::get("archivos.tamano_maximo")) {
				return Redirect::to($url)->withErrors(["Imágen supera el tamaño máximo"])->withInput();;
			}
			//dd(base_path() . '/public/'.Config::get("paths.UPLOADS").'/'.Config::get("paths.USERS").'/'. $imageName);
			$ruta = public_path() . '/' . Config::get("rutas.contenidos") . '/' . Config::get("rutas.banners") . '/';
			$IMAGE->move($ruta, $nuevoNombre);
			$banner->nombre = $nuevoNombre;
			$banner->url 	= $ruta;
			$banner->creado = new \DateTime();
			$banner->creado_por = $usuario->id;
			$banner->save();
		}else{
			return Redirect::to($url)->withErrors(["La imágen es requerida"])->withInput();;
		}

		//Información almacenada
		$url = '/admin_contenidos/banners' ."?salvado=y&" . str_random(16); //Le añadimos un string random al final del URL para evitar el cache y para volver la URL más difícil de leer.
		return Redirect::to( $url  );
	}

	public function borrarBanner($usuario){
		if(Request::segment(3) != ''){
			$id = Request::segment(3);
			$banner = banner::find($id);
			if($banner != null){
				$banner->delete();
				return 1;
			}
			return 0;
		}
		return 0;
	}

	public function actualizarOrdenBanner($usuario){
		if(Input::get('orden') != ''){
			//así como viene el orden, tenemos que actualizar
			$ids = explode(',',Input::get('orden'));
			$cont = 1;
			foreach($ids AS $id){
				$aux = banner::find($id);
				if($aux != null){
					$aux->orden = $cont;
					$aux->save();
					$cont++;
				}
			}
			echo Input::get('orden');

		}
		return 0;
	}
}
