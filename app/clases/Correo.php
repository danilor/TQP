<?php
namespace App\clases;
use Config;
use App;
use Request;
use Response;
use View;
use DB;
use Mail;
/*Esta clase se encargará de generar los registros de correos y además de enviarlos luego por medio de un comando de artisan*/
class Correo{
    public static function generarCorreo($tema,$plantilla,$para_correo,$para_nombre,$cuerpo,$cuerpo2=""){

        $vista = view("correo/" . $plantilla) -> with(["titulo"=>$tema,"contenido"=>$cuerpo]);

        $correo = new \Tiqueso\registro_correo;
        $correo -> tema = $tema;
        $correo -> cuerpo = serialize(["titulo"=>$tema,"contenido"=>$cuerpo,"contenido2"=>$cuerpo2]);
        $correo -> plantilla = $plantilla;
        $correo -> para_correo = $para_correo;
        $correo -> para_nombre = $para_nombre;
        $correo -> estado = 0;
        $correo -> save();
    }

    /*
     * Esta función obtiene los correos para enviar
     * @param $l El límite de correos
     * */
    public static function obtenerCorreosParaEnviar($l){
        $tabla = "registro_correos";
        //Se obtienen los N correos más viejos sin enviar para enviarlos.
        $q = DB::table($tabla)->where("estado",0)->orderBy("created_at","asc");
        return $q->get();
    }

    //Esta función envía el correo. Por el momento solo envía por el cuerpo completo (raw). Más adelante si es necesario se puede incluir vistas complejas.
    public static function enviarDesdeRegistro($r){
        try{
            if($r->cuerpo != ""){
                Mail::send("correo.".$r->plantilla ,unserialize($r->cuerpo), function ($m) use ($r){
                    $m->to($r->para_correo, $r->para_nombre)->subject($r->tema);
                    $m->from(Config::get("mail.correo_notificaciones"), Config::get("mail.nombre_notificaciones"));
                });
            }
            return true;
        }catch (\Exception $e){
            dd($e->getMessage());
            return false;
        }

    }

}
?>