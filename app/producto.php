<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{

    public $timestamps = false;

    /*
     * Función solamente para establecer el código del producto
     * */
    public function obtenerCodigoFinal(){
        $this -> codigo = $this->codigo_tipo . $this->codigo_proveedor . $this->dia_juliano . $this->tanda;
    }
}
