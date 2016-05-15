<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class receta extends Model
{
    public $timestamps = false; //le indicamos que este objeto no va a usar los timestamps
    public function obtenerFechaCreacion(){
        $dated = strtotime($this->creado);
        return date(config('region.formato_fecha'),$dated);
    }

    public function obtenerProductosRelacionados(){
        $aux = explode(',',$this->productos_relacionados);
        $aux_respuesta = [];
        foreach($aux AS $p){
            $tp = tipo_producto::find($p);
            if($tp != null){
                $aux_respuesta[] = $tp;
            }
        }
        return $aux_respuesta;
    }

    /*
     * Con esta función podemos saber si un producto (codigo) existe como producto relacionado
     * */
    public function tieneProducto($codigo){
        $aux = explode(',',$this->productos_relacionados);
        if(in_array($codigo,$aux)){
            return true;
        }
        return false;
    }

}
