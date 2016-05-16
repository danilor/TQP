<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class banner extends Model
{
    public $timestamps = false; //le indicamos que este objeto no va a usar los timestamps
    public $usuario = null;

    public function obtenerRutaImagen(){
        return '/' . config("rutas.contenidos"). '/' . config("rutas.banners") . '/' . $this->nombre;
    }

    public function obtenerUsuario(){
        if($this->usuario == null){
            $this->usuario = usuario::find($this->creado_por);
        }
        return $this->usuario;
    }
}
