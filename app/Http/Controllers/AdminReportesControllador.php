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
class AdminReportesControllador  extends Controller {

	private $reglas = array(
		/*DASHBOARD*/
		'get|correos'                      	=>  'reporteCorreos',
		'get|ingresos'						=>	'reporteIngresos',
		'get|procesos'						=>	'reporteProcesos',
		'get|inventarios'					=>	'reporteInventarios',
		'get|ingresos_producto'				=>	'reporteIngresoDeProductos',
		'get|seguimientos'					=>	'reporteSeguimientos',
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

	public function reporteCorreos($usuario){
		$data["usuario"] = $usuario;
		$fecha_inicial 	= $date = (new \DateTime())->modify('-60 days');; //Establecemos la fecha inicial predeterminada
		$fecha_inicial -> setTime(0,0,0);
		$fecha_final 	= $date = (new \DateTime())->modify('+60 days');; //Establecemos la fecha inicial predeterminada
		$fecha_final -> setTime(24,59,59);
		if(Input::get('fechainicio') != "" ){
			$fecha_inicial = \DateTime::createFromFormat(config('region.formato_fecha'),Input::get('fechainicio'));
			$fecha_inicial -> setTime(0,0,0);
		}
		if(Input::get('fechafin') != "" ){
			$fecha_final = \DateTime::createFromFormat(config('region.formato_fecha'),Input::get('fechafin'));
			$fecha_final -> setTime(0,0,0);
		}
		$termino = '';
		$correos = DB::table('registro_correos');
		if(Input::get('termino') != "" ){
			$termino = Input::get('termino');

			$correos->where(function ($query) use($termino) {
				$query->orWhere('tema', 'LIKE', "%$termino%")->orWhere('cuerpo', 'LIKE', "%$termino%")->orWhere('plantilla', 'LIKE', "%$termino%")->orWhere('para_correo', 'LIKE', "%$termino%")->orWhere('para_nombre', 'LIKE', "%$termino%");
			});
		}
		$correos->where('created_at','>=',$fecha_inicial);
		$correos->where('created_at','<=',$fecha_final);
		$data['fecha_inicial'] 	= $fecha_inicial;
		$data['fecha_final'] 	= $fecha_final;
		$data['termino'] 	= $termino;
		$data['correos'] = $correos->get();
		return view('admin_reportes/correo')->with($data);
	}

	public function reporteIngresos($usuario){
		$data["usuario"] = $usuario;
		$query = DB::table('registro_ingreso')->orderBy('id','DESC')->take(1000)->get();
		$data['ingresos'] = $query;
		return view('admin_reportes/ingresos')->with($data);
	}

	public function reporteProcesos($usuario){
		$data["usuario"] = $usuario;
		$query = \Tiqueso\proceso::orderBy('id','DESC')->take(10000)->get();

		$data["procesos"] = $query;

		$grafico = [];
		foreach($query AS $p){
			if(!isset($grafico[date('Y-m-d',strtotime($p->iniciado_fecha))])){
				$grafico[date('Y-m-d',strtotime($p->iniciado_fecha))]['ini'] = 0;
				$grafico[date('Y-m-d',strtotime($p->iniciado_fecha))]['fin'] = 0;
			}
			if(!isset($grafico[date('Y-m-d',strtotime($p->finalizado_fecha))])){
				$grafico[date('Y-m-d',strtotime($p->finalizado_fecha))]['ini'] = 0;
				$grafico[date('Y-m-d',strtotime($p->finalizado_fecha))]['fin'] = 0;
			}
			$grafico[date('Y-m-d',strtotime($p->iniciado_fecha))]['ini']++;
			$grafico[date('Y-m-d',strtotime($p->finalizado_fecha))]['fin']++;

		}
		$data["grafico"] = $grafico;
		return view('admin_reportes/procesos')->with($data);
	}

	public function reporteInventarios($usuario){

		$inventarios = DB::table("inventarios")->select('inventarios.*','usuarios.nombre AS usuario_nombre','usuarios.apellido AS usuario_apellido')->where("estado",1)->leftJoin('usuarios', 'usuarios.id', '=', 'inventarios.usuario')->orderBy("id","DESC")->take(5000)->get();
		$data["usuario"] = $usuario;
		$data["inventarios"] = $inventarios;
		return view('admin_reportes/inventarios')->with($data);

	}


	public function reporteIngresoDeProductos( \Tiqueso\usuario $Usuario ){
		$data["usuario"] = $Usuario;
		$data["max"] = 100;
		if( \Input::get("max") != "" && is_numeric(\Input::get("max")) ){
			$data["max"] = \Input::get("max");
		}
		$q = \Tiqueso\registro_producto::orderBy("id","desc");
		$data["registros"] = $q->take( (int)$data["max"] )->get();
		return view('admin_reportes/registros_productos')->with($data);
	}

	public function reporteSeguimientos( \Tiqueso\usuario $Usuario ){
		$data["usuario"] = $Usuario;
		$data["usuarios"] = [];

		$Usuarios = \Tiqueso\usuario::all();

		foreach( $Usuarios AS $usuario ){
				$data["usuarios"][ $usuario->id ] = $usuario->obtenerNombreCompleto() . ' (' . $usuario->correo . ')';

		}

		return view('admin_reportes/seguimientos')->with($data);
	}

}
