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
		'get|'                      	=>  'tablero',
		'get|mi_tablero'                =>  'mi_tablero',

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

	public function tablero($usuario){
		$data["usuario"] = $usuario;

		/*
		 * Ocupamos hacer las consultas de los gráficos
		 * */
		$informacion_grafico = [];
		$ingresados = \DB::select('SELECT DATE_FORMAT(registrado,\'%Y-%m-%d\')AS fecha, COUNT(*) AS total FROM productos
				WHERE
					(registrado BETWEEN DATE_SUB(NOW(),INTERVAL 7 DAY) AND NOW())
					AND borrado = 0
				GROUP BY
				DATE_FORMAT(registrado,\'%Y-%m-%d\')
				;');

		$salidas = \DB::select('SELECT DATE_FORMAT(modificado,\'%Y-%m-%d\')AS fecha, COUNT(*) AS total FROM productos
						WHERE
							(registrado BETWEEN DATE_SUB(NOW(),INTERVAL 7 DAY) AND NOW())
							AND borrado = 0
							AND estado = 0
						GROUP BY
						DATE_FORMAT(modificado,\'%Y-%m-%d\')
						;');
		foreach($ingresados AS $i){
			if(!isset($informacion_grafico[$i->fecha])){
				$informacion_grafico[$i->fecha] = [
					'entradas'		=>		0,
					'salidas'		=>		0,
				];
			}
			$informacion_grafico[$i->fecha]['entradas'] = $i->total;
		}

		foreach($salidas AS $i){
			if(!isset($informacion_grafico[$i->fecha])){
				$informacion_grafico[$i->fecha] = [
					'entradas'		=>		0,
					'salidas'		=>		0,
				];
			}
			$informacion_grafico[$i->fecha]['salidas'] = $i->total;
		}

		$data["grafico"] = $informacion_grafico;

		$res = DB::select("SELECT SUM(inventarios.cantidad) AS cantidad, inventarios.codigo AS codigo, tipo_productos.nombre AS nombre FROM inventarios LEFT JOIN tipo_productos ON tipo_productos.codigo = inventarios.codigo WHERE inventarios.estado = 1 GROUP BY inventarios.codigo");

		$data["grafico_circular"] = $res;

		$data["registros_ingreso"] = \Tiqueso\registro_producto::whereRaw('finalizado IS NULL')->get();

		// dd($data["registros_progreso"] );

		return view('admin_general/tablero')->with($data);
	}

	public function mi_tablero($usuario){
		$data["usuario"] = $usuario;
		$data["registros_ingreso"] = \Tiqueso\registro_producto::whereRaw('finalizado IS NULL')->where("usuario",$usuario->id)->get();
		return view('admin_general/mi_tablero')->with($data);

	}

}
