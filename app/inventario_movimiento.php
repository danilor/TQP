<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class inventario_movimiento extends Model
{
    public $timestamps = false;
    private $usuario = null;

    public function obtenerUsuario(){
        if( $this->usuario == null ){
            $this->usuario = usuario::find($this->usuario);
        }
        return $this->usuario;
    }
}
