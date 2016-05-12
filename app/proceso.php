<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class proceso extends Model
{
    public $timestamps = false;

    private $usuario_iniciado = null;

    /*
     * Esta función devuelve en un array la lista de códigos de procesos
     * */
    public function obtenerCodigos(){
        return explode(',',$this->productos_proceso);

    }

    public function usuario_inicial(){
        if($this->usuario_iniciado == null){
            $this->usuario_iniciado = usuario::find($this->iniciado_por);
        }
        return $this->usuario_iniciado;
    }

}
