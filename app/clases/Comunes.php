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
        return Response::make(View::make('errores/404'), 404);
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

}
?>