<?php
namespace App\clases;
use Config;
use App;
use Faker\Provider\zh_TW\DateTime;
use Mockery\CountValidator\Exception;
use Request;
use Response;
use View;
use DB;
class Usuario{

    private $elementos = ["id","nombre","apellido","correo","usuario","cedula","apodo","sexo","foto"];

    public function __construct($usuario){
        foreach($this->elementos AS $key => $u){
            try{
                $this->$u = $usuario->$u;
            }catch(\Exception $e){
                    dd($e);
            }

        }
    }
    public function obtenerNombreCompleto(){
        return "$this->nombre $this->apellido";
    }


    /*
     * Métodos estáticos para llamar sin necesidad de instanciar el objeto usuario. Todos están relacionados con acciones del usuario propiamente.
     * */

    public static function registrarRecuperarContrasena($id){
        // Generamos un código (token) aleatorio. Para que este sea realmente aleatorio estamos combinando la fecha actual (año hasta segundo) y un número aleatorio con la sesión.
        // Ésto nos asegura de que el código es completamente único.
        $codigo = date("YmdHhims") . str_random(32) . @session_id();
        \Tiqueso\recuperar_contrasena::where("id_usuario",$id)->update(["estado"=>0]); //Primero desactivamos todos los estados anteriores. Así no van a quedar códigos sin usar de un mismo usuario

        //Ahora creamos el nuevo registro con el nuevo código.
        $fechaActual = new \DateTime(); //La fecha es importante porque los códigos van a tener un tiempo predeterminado para ser usados. Pasado ese tiempo los códigos son inválidos.
        $recuperer_contrasena = new \Tiqueso\recuperar_contrasena;
        $recuperer_contrasena -> id_usuario = $id;
        $recuperer_contrasena -> codigo = $codigo;
        $recuperer_contrasena -> estado = 1;
        $recuperer_contrasena -> created_at = $fechaActual;
        $recuperer_contrasena -> updated_at = $fechaActual;
        $recuperer_contrasena -> save();
        return $codigo;
    }


    public static function enviarContraseña($usuario){
            //Primero generamos y obtenemos el código con el que vamos a trabajar
                    $codigo = self::registrarRecuperarContrasena($usuario->id);
                    //Ahora generamos el correo. Aunque no se envíe inmediatamente, hay un proceso existente que lo envía luego.
                    $url = Request::root() . "/recobrar/$codigo";
                    $cuerpo = "
                                <p>Este correo le ha sido enviado porque se ha solicitado un proceso de recuperación de contraseña para el usuario <strong>" . $usuario->usuario . "</strong>. Si usted no ha solicitado este proceso por favor hacer caso omiso a este mensaje.</p>
                                <p>Para recuperar y reestablecer su contraseña por favor hacer clic al siguiente vínculo:</p>
                                <ul>
                                    <li><a href='$url'>$url</a></li>
                                </ul>
                                <p>Este código es válido por las próximas 2 horas.</p>
                                <p>Si al hacer clic no se abre su navegador, por favor copiar el enlace y pegarlo directamente en su navegador para poder acceder al proceso indicado.</p>
                                <p>Si tiene alguna duda o consulta puede contactarnos mediante nuestro sistema de <i>CONTACTO</i> y le atenderemos lo más pronto posible.</p>
                            ";
                    Correo::generarCorreo("Recuperación de Contraseña","basica",$usuario->correo,"$usuario->nombre $usuario->apellido",$cuerpo);
                    //Con el correo generado solo queda esperar que el proceso prosiga su camino automáticamente

    }

}
?>