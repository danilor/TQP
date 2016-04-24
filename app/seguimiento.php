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
    public function obtenerUsuarioAsignado(){
        if( $this -> usuario_asignado == null ){
            $this -> usuario_asignado = usuario::find( $this -> asignado_a );
        }
        return  $this -> usuario_asignado;
    }

    /* Esta función obtiene la URL de GOOGLE MAPS para mostrar */
    public function obtenerURLMapa($zoom = '14z'){
        $base = 'http://www.google.com/maps/place/[LAT],[LON]/@[LAT],[LON],' . $zoom; //La URL Base
        $url = str_replace([ "[LAT]" , "[LON]" ],[ $this -> latitud ,  $this -> longitud] , $base);
        return $url;
    }
}
