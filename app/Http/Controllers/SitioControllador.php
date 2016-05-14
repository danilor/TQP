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
use App\clases\Cliente ;
use URL;



//Este controllador se encargara de gestionar las peticiones de dicho objeto
class SitioControllador  extends Controller {

	public function pagina_principal(){
		$data = [];

		$productos = \Tiqueso\tipo_producto::where('estado',1)->where('mostrar',1)->where('foto','<>','')->orderByRaw("RAND()")->take(4)->get();
		$data["productos"] = $productos;
		return view('principal.inicio')->with($data);
	}

	public function recetas(){
		$data = [];
		$id = Request::segment(2);
		$receta = \Tiqueso\receta::find($id);
		if($receta == null){
			return Comunes::enviar404();
		}
		$data['receta'] = $receta;
		return view('principal.recetas')->with($data);

	}

}
