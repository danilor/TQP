<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class registro_producto extends Model
{
    public $timestamps = false;
    public $usuario_objeto = null;

    public function obtenerCampos(){
        return unserialize($this->formulario);
    }
    public function obtenerUsuario(){
        if( $this->usuario_objeto == null ){
            $this->usuario_objeto = usuario::find($this->usuario);
        }

        return $this->usuario_objeto;
    }

}
