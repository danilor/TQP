<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;
use Tiqueso\usuario;

class seguimiento extends Model
{

    private $usuario_creado = null; //Inicializamos la variable de usuario para reutilizarla sin necesidad de volver a consultar la base de datos.
    private $usuario_asignado = null; //Inicializamos la variable de usuario para reutilizarla sin necesidad de volver a consultar la base de datos.

    //
    /*
     * Esta función pretende el obtener la fecha de manera de "formato" para mostrar a los usuarios. También
     * puede devolver la fecha sin formato
     * */
    public function obtenerFecha($formato = true){
        if($formato){
            return date(\Config::get("region.formato_fecha_completo"),strtotime($this->creado));
        }
        return $this -> creado;
    }

    public function obtenerUsuarioCreado(){
        if( $this -> usuario_creado == null ){
            $this -> usuario_creado = usuario::find( $this -> creado_por );
        }
        return  $this -> usuario_creado;
    }
}
