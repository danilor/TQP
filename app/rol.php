<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class rol extends Model
{
    /*
     * Predeterminadamente, Laravel busca una tabla que sea el prural del nombre de la clase. En este caso buscaría una tabla
     * llamada "rols", es por esto que tenemos que sobreescribir este atributo e indicarle el verdadero nombre de la tabla que es "roles".
     * (Problemas de pasar de inglés a español en estos casos)
     * */
    protected $table = 'roles';
    private $divisor = ","; //El divisor de los permisos dentro del rol. Esto puede cambiar
    private $permisos_almacenados = null;

    /*
     * Esta función va a obtener los permisos en modo string.
     * */
    public function obtenerPermisos_String($union = ","){
        return implode($union,$this->obtenerPermisos_Array());
    }

    /*
     * Esta función va a obtener los roles en modo array
     * */
    public function obtenerPermisos_Array(){
        if($this -> permisos_almacenados == null){
            $this -> permisos_almacenados = explode($this->divisor,$this->permisos);
            foreach( $this -> permisos_almacenados AS $key => $value  ){ //Vamos a limpiar los permisos que no tienen nada realmente
                if( trim($value) == "" ){
                    unset($this -> permisos_almacenados[$key] );
                }
            }
        }
        return $this -> permisos_almacenados;
    }

}
