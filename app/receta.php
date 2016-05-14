<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class receta extends Model
{
    //
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
}
