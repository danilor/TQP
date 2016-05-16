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

	public function productos(){
		$data = [];
		$productos = \Tiqueso\tipo_producto::where('estado',1)->where('mostrar',1)->orderByRaw("RAND()")->where('foto','<>','')->get();
		$data["productos"] = $productos;
		return view('principal.productos')->with($data);
	}

	public function producto_individual(){
		$data = [];
		$id = Request::segment(2);
		$producto = \Tiqueso\tipo_producto::find($id);
		if($producto == null){
			Comunes::enviar404();
		}
		$data["producto"] = $producto;
		return view('principal.producto')->with($data);
	}

	public function recetas_lista(){
		$data = [];
		$recetas_principal = \Tiqueso\receta::orderBy('creado','DESC');
		if(Input::get('producto') != ''){
			$p = Input::get('producto');
			$recetas_principal->where('productos_relacionados','LIKE',"%$p%");
		}
		$recetas = $recetas_principal->paginate(10);

		$producto_id = '00';
		$data['producto'] = $producto_id;
		$data['recetas'] = $recetas;
		return view('principal.recetas_lista')->with($data);
	}

	public function acerca_de(){
		$data = [];
		return view('principal.acerca_de')->with($data);
	}

	public function contacto(){
		$data = [];
		return view('principal.contacto')->with($data);
	}

	public function salvar_contacto(){
		$url = \URL::previous();
		$url = explode("?", $url)[0]; //Removemos el query string en caso de que exista

		$rules = array(
			'nombre' 			=> Comunes::reglas('textogenerico', true),
			'correo'			=> Comunes::reglas('correo', true),
			'tema'				=> Comunes::reglas('textogenerico', true),
			'mensaje'			=> Comunes::reglas('textogenerico', true),
			'telefono' 			=> Comunes::reglas('textogenerico', false),
			'compania' 			=> Comunes::reglas('textogenerico', false),
		);

		$validador = Validator::make(Input::all(), $rules);
		if ($validador->fails()) {
			return Redirect::to($url)->withErrors($validador)->withInput();
		}

		//Parece que podemos almacenar la información

		$mensaje = new \Tiqueso\mensaje();
		$mensaje -> nombre = Input::get('nombre');
		$mensaje -> tema = Input::get('tema');
		$mensaje -> mensaje = Input::get('mensaje');
		$mensaje -> correo = Input::get('correo');
		$mensaje -> telefono = Input::get('telefono');
		$mensaje -> compania = Input::get('compania');
		$mensaje -> creado = new \DateTime();

		$mensaje -> save();

		return Redirect::to("/contacto?enviado=y");

	}

}
