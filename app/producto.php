<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{

    public $timestamps = false;
    private $tipo_producto = null;

    /*
     * Función solamente para establecer el código del producto
     * */
    public function obtenerCodigoFinal(){
        $this -> codigo = $this->codigo_tipo . $this->codigo_proveedor . $this->dia_juliano . $this->tanda;
    }


    public function obtenerImagenTipoProducto($ancho = 200,$alto = 200){
        $ruta = "/general/foto_tipo_producto/" . $this->codigo_tipo . "?w=$ancho&h=$alto&type=fit";
        return $ruta;
    }

    public function obtener_tipo_producto(){
        if($this->tipo_producto == null){
            $this->tipo_producto = tipo_producto::where('codigo',$this->codigo_tipo)->first();
        }
        return $this->tipo_producto;
    }

    /*
     * Cuando un producto entra a un proceso, es necesario el cerrarlo para que no esté mas en la lista de productos disponibles
     * */
    public static function cerrarProducto($codigo){
        $producto = self::where('codigo',$codigo)->first();
        if($producto == null){
            return false;
        }
        $producto -> estado = 0;
        $producto -> save(); //Salvamos el cambio al producto
        return true;
    }


}
