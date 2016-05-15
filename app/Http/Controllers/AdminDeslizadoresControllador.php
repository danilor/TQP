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
use URL;
use App\clases\Comunes;
use App\clases\Usuario;
use App\clases\Deslizador;



//Este controllador se encargara de gestionar las peticiones de dicho objeto
class AdminDeslizadoresControllador  extends Controller {
        private  $nombre_objeto_plural ;
        
	private $reglas = array(
		/*DASHBOARD*/
		'get|ver' =>  'ver',
                'get|borrar' =>  'borrar',
		'get|modificar' => 'modificar',
		'post|salvar_informacion' =>'salvarInformacion'
        );

	public function __construct(){
           
	}

	public function principal(){
            $nombre_archivo_actual = basename(__FILE__, '.php');//Se obtiene el nombre del controlador actual
            $this->nombre_objeto_plural = strtolower(str_replace(array("Admin","Controllador"), "" , $nombre_archivo_actual ) );// Se obtiene el nombre del objeto en plural ejemplo : clientes, proveedores
            $this->nombre_objeto = str_replace("res","r",$this->nombre_objeto_plural);
            
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
	 * Esta función se encarga solamente de mostrar los clientes. 
	 * */
	public function ver($usuario){
            $data["usuario"] = $usuario;
            $data["arreglo_principal_objetos"]= DB::table( "$this->nombre_objeto_plural" )->get();
            $schema = \DB::getDoctrineSchemaManager();
            $data["columnas_escructura"] = $schema->listTableColumns($this->nombre_objeto_plural);
            $data["nombre_objeto"] = $this->nombre_objeto;
            $data["nombre_objeto_primero_mayus"] = ucfirst( $this->nombre_objeto );
            $data["nombre_objeto_plural"] = $this->nombre_objeto_plural;
            $data["nombre_objeto_plural_primero_mayus"] = ucfirst( $this->nombre_objeto_plural );
           
            return view("admin_$this->nombre_objeto_plural/ver")->with($data);
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
	public function borrar($usuario){
		$id_objeto = Request::segment(3);
		DB::delete("Delete from $this->nombre_objeto_plural WHERE id=$id_objeto");
                return Redirect::to("admin_$this->nombre_objeto_plural/ver");
	}

	/*
	 * Estas función muestra la página de modificar usuario. Va a contener mucha información del mismo perfil pero añadiendo ciertos
	 * campos especiales que solamente una persona con permisos podría modificar, por ejemplo grados académicos entre otros.
	 * */
	public function modificar($usuario){
            
            $schema = \DB::getDoctrineSchemaManager();
            $data["columnas_escructura"] = $schema->listTableColumns($this->nombre_objeto_plural);
            $data["nombre_objeto"] = $this->nombre_objeto;
            $data["nombre_objeto_primero_mayus"] = ucfirst( $this->nombre_objeto );
            
            $data["nombre_objeto_plural"] = $this->nombre_objeto_plural;
            $data["nombre_objeto_plural_primero_mayus"] = ucfirst( $this->nombre_objeto_plural );
            $id_objeto = Request::segment(3);
           
            $objeto = Deslizador::find( $id_objeto ); //Busca al objeto con el ID
            $data["usuario"] = $usuario;
            $data["objeto"] = $objeto; //Este es el objeto que estamos modificando,
            if($objeto == null ){ //Es nulo! Volvamos a la lista de objetos porque posiblemente sea un error.
			return Redirect::to("admin_$nombre_objeto_plural/ver?modificar=proveedor_no_encontrado&".str_random(16)); //añadimos un string aleatorio para dificultar la lectura del URL.
            }
            //Podemos mostrar la página
  
                
            return view("admin_$this->nombre_objeto_plural/modificar")->with($data);
	}

	/*
	 * Este proceso es el encargado de salvar la información del objeto. Debería de funcionar tanto para objetos nuevos como para ya existentes.
	 * */
	public function salvarInformacion( $usuario ){
            /*$imagenes =( Input::FILE("imagenes"));
            foreach( $imagenes as $imagen) {
                
               $nuevo_nombre = "DESLIZADOR_IMAGEN_". date("Ymd")."_".str_random(8)."_".$imagen->getClientOriginalExtension();
               $ruta = public_path() . '/' . Config::get("rutas.contenidos") . '/' . Config::get("rutas.banners") . '/';
               $imagen->move( $ruta, $nuevo_nombre );
               
               $objeto = new \App\clases\DeslizadorImagen;
               $objeto->url( $nuevo_nombre);
               $objeto->save();
            }*/
            
            if( Input::get("id") != null ) {//Objeto a modificar
                $objeto = Deslizador::find( Input::get("id") );
            }else { // Objeto nuevo
                $objeto = new Deslizador()  ;
            }
            //var_dump($objeto);
            $campos = Input::except('_token') ;
            $objeto->timestamps = false;// inabilitar actualizar timestamps pq crea error de actualizar la columna created at y updated at
            foreach ( $campos as $clave => $valor){
                $objeto->$clave = $valor;
            }
            $objeto ->actualizado = new \DateTime();//Usara current time stamp de la base de datos para su fecha
            $objeto->save();
            

            return Redirect::to( URL::previous()."?salvado=y"  );

            
	}















}
