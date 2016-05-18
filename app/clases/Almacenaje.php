<?php
namespace App\clases;
use Config;
use App;
use Request;
use Response;
use View;
use DB;
class Almacenaje{

    /*
     * Obtiene la información necesaria para un select de almacenaje
     * */
    public static function obtenerSelectAlmacenaje($vacio = false,$estado = 1, $borrado = 0){
        $almacenajes = \Tiqueso\almacenaje::where('estado',$estado)->where('borrado',$borrado)->get();
        $aux_almacenajes = [];
        if($vacio){
            $aux_almacenajes[0] = 'Seleccione un centro de almacenaje';
        }
        if(count($almacenajes) == 0){
            $aux_almacenajes[0] = 'No existen centros de almacenaje válidos';
            return $aux_almacenajes;
        }
        foreach($almacenajes AS $a){
            $aux_almacenajes[$a->id] = $a->nombre;
        }
        return $aux_almacenajes;
    }
}
?>