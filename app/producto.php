<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{

    public $timestamps = false;
    private $tipo_producto = null;
    private $presentacion = null;

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

    /*
     * Esta función obtiene la presentación del producto en caso de que sea diferente de 0
     * */
    public function obtenerPresentacion(){
        if($this->presentacion == null && $this->codigo_proveedor != ""){
            $this->presentacion = producto_presentacion::find($this->codigo_proveedor);
        }
        return $this->presentacion;
    }

    /*
     * Esta función lee, construye y devuelve todos los objetos de materias primas
     * */
    public function obtenerObjetosDeMateriasPrimas(){

        $aux_resultado = [];
        $materias_primas = explode(',',$this->materias_primas); //Obtenemos todas las materias primas

        foreach($materias_primas AS $mp){
            $aux = producto::where('codigo',$mp)->first();
            if($aux != null){ //Si el codigo no es null, entonces lo añadimos a la lista de materias primas
                $aux_resultado[] = $aux;
            }
        }

        return $aux_resultado;

    }


}
