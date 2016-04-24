<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;
use Config;

class tipo_producto extends Model
{

    protected $primaryKey = 'codigo'; //Para este caso en particular establecemos el código como el PRIMARY KEY de la tabla

    /*
     * Esta función busca obtener la foto del tipo de producto para poder mostrarla. Si la foto no existe muestra la predeterminada
     * */
    public function obtenerFoto(){
        if($this->foto == ""){
            return Config::get("archivos.imagen_predeterminado");
        }else{
            //Tenemos que construir la ruta
            $ruta = "/" . Config::get("rutas.contenidos") . "/" . Config::get("rutas.tipo_productos") . "/" . $this->foto;
            return $ruta;
        }
    }
}
