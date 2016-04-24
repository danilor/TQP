<?php namespace Tiqueso\Http\Controllers;
use Illuminate\Support\Str;
use Request;
use Input;
use Redirect;
use Auth;
use Tiqueso\categoria_producto;
use Validator;
use Config;
use Hash;
use Session;
use DB;
use App\clases\Comunes;
use App\clases\Usuario;
use App\clases\RespuestaAjax;


//This class will take care of the login information
class SeguimientosControllador extends Controller {

	private $reglas = array(
		'get|historial'						=>	'historialSeguimiento',
		'post|nuevo_seguimiento'         	=>  'nuevoSeguimiento', //AJAX
		'get|seguimientos_de_usuario'    	=>  'seguimientoDeUsuario', //AJAX
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
	 * Función para añadir nuevos seguimientos. Esta función va a obtener la información de nuevos así como de seguimientos
	 * con algún historial, así que debería de funcionar para ambos casos sin problemas.
	 * MODO: AJAX
	 * */
	public function nuevoSeguimiento(\Tiqueso\usuario $usuario){
		$respuesta = new RespuestaAjax("Seguimiento","Nuevo");

		$reglas = array(
			'usuario' 		=> Comunes::reglas('id_usuario', true),
			'detalle' 		=> Comunes::reglas('textogenerico_min', true),
		);
		$validador = Validator::make(Input::all(), $reglas);
		if ($validador -> fails()) {
			$aux = []; //Queremos recobrar todos los campos que generaron error.
			foreach( $validador->errors()->getMessages() AS $key => $value ){
					$aux["campos"][] = $key;
			}
			$respuesta->establecerErrores(1 , $respuesta->mensaje_error_general , $aux);
			return $respuesta -> imprimirRespuesta();
		}

		$id_unico = date("Ymd") . str_random(32); //Generamos un ID único que va a pertenecer al grupo de seguimientos.

		if( Input::get("unico") != ""){ //Si viene algún único, entonces usamos ese y cerramos todos los únicos anteriores
			$id_unico = Input::get("unico");
			\Tiqueso\seguimiento::where("unico",$id_unico) -> update(["estado"=>0]);
		}

		$uid 		= (int)Input::get("usuario");
		$detalle 	= Input::get("detalle");
		$lat 		= Input::get("geo_lat");
		$lon 		= Input::get("geo_lon");

		$seguimiento = new \Tiqueso\seguimiento();

		$seguimiento -> unico 		=	$id_unico;
		$seguimiento -> creado_por 	=	$usuario -> id;
		$seguimiento -> asignado_a 	=	$uid;
		$seguimiento -> mensaje 	=	$detalle;
		$seguimiento -> latitud		=	$lat;
		$seguimiento -> longitud	=	$lon;

		$seguimiento -> creado 		=	new \DateTime();

		if(Input::get("cerrar") != ""){ //Significa que tenemos que cerrar el seguimiento con el comentario
			$seguimiento -> estado 		=	0;
			$seguimiento -> cerrado 	=	new \DateTime();
		}else{
			$seguimiento -> estado 		=	1;
		}
		$seguimiento -> save(); //Salvamos el nuevo seguimiento

		$respuesta -> setRespuesta( [ "id" => $seguimiento -> id ] );

		return $respuesta -> imprimirRespuesta();
	}

	public function seguimientoDeUsuario(\Tiqueso\usuario $usuario){
		$respuesta = new RespuestaAjax("Seguimiento","Usuario");
		$respuesta -> setRespuesta( [ "total" => Auth::user()->totalSeguimientos() ] );

		return $respuesta -> imprimirRespuesta();
	}

	/*
	 * Esta función y página relacionada se encarga de mostrar el historial completo de un seguimiento usando su UNICO.
	 * */
	public function historialSeguimiento(\Tiqueso\usuario $usuario){
		$data["usuario"] = Auth::user();
		return view('admin_seguimientos/historial')->with($data);
	}

}
