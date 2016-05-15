<?php
namespace App\clases;
use Config;
use App;
use Request;
use Response;
use View;
use DB;
class Comunes{
    public static function reglas($name,$required = false, $extra = ""){
        $mainR = Config::get('reglas.'.$name);
        if($required){ $mainR = "required|".$mainR; }
        if(strlen($extra)>0){ $mainR .= "|".$extra; }
        return $mainR;
    }

    public static function enviar404(){
        return Response::make(View::make('errors/404'), 404);
        dd("Pàgina 404");
    }

    public static function getListaRolesSelect(){
        $aux = [];
        $roles = \Tiqueso\rol::orderBy("nombre","asc")->get();
        foreach($roles AS $r){
            $aux[$r->id] = $r->nombre;
        }
        return $aux;
    }

    public static function getListaPermisosSelect(){
        $aux = [];
        $roles = \Tiqueso\permiso::orderBy("nombre","asc")->get();
        foreach($roles AS $r){
            $aux[$r->alias] = $r->nombre;
        }
        return $aux;
    }

    /*
     * Obtenemos la lista de usuarios para montarla sobre un SELECT.
     * @param excepcion Si la excepcion es distinta de null quiere decir que queremos excluir a un usuario en particular
     * */
    public static function getUsuariosSelect($excepcion = null){
        $usuarios = \Tiqueso\usuario::where("activo",1)->get();
        $aux = [];
        foreach($usuarios AS $key => $value){ //Iteramos por toda la lista de usuarios existentes
            if($excepcion != null){
                if( (int)$value->id != (int)$excepcion ){
                    $aux[$value->id] = $value->obtenerNombreCompleto();
                }
            }else{
                $aux[$value->id] = $value->obtenerNombreCompleto();
            }
        }
        return $aux; //Retornamos el auxiliar que contiene los IDS y NOMBRES de los usuarios solamente
    }

    /*
     * Regresa la fecha en un mejor formato y para una mejor referencia
     * Obtenido de: http://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
 */

    public static function timeElapsedString($ptime){
        $diff = time() - $ptime;
        $calc_times = array();
        $timeleft   = array();

        // Prepare array, depending on the output we want to get.
        $calc_times[] = array('Año',   'Años',   31557600);
        $calc_times[] = array('Mes',  'Meses',  2592000);
        $calc_times[] = array('Día',    'Días',    86400);
        $calc_times[] = array('Horas',   'Horas',   3600);
        $calc_times[] = array('Minuto', 'Minutos', 60);
        $calc_times[] = array('Segundo', 'Segundos', 1);

        foreach ($calc_times AS $timedata){
            list($time_sing, $time_plur, $offset) = $timedata;

            if ($diff >= $offset){
                $left = floor($diff / $offset);
                $diff -= ($left * $offset);
                $timeleft[] = "{$left} " . ($left == 1 ? $time_sing : $time_plur);
            }
        }

        return $timeleft ? (time() > $ptime ? null : '-') . implode(' ', $timeleft) : 0;
    }

}
?>