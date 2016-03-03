<?php
namespace App\clases;

/*
    Esta clase controla todos los aspectos de las respuestas de las peticiones AJAX. Esto
    debido a que se quiere que todas las respuestas tengan el mismo formato y estructura para así ser
    estándart a través del sitio
*/
class RespuestaAjax{


    public $mensaje_error_general = "Ocurrió un error al procesar la petición. Por favor revise los datos e inténtelo de nuevo";

    private $nombre; //El nombre de la función
    private $area; //El área de la función. No es necesario
    private $respuesta = null; //Esta es la respuesta propia de cada petición
    private $estructura = null; // Esta es la variable que va a contener la estructura de la respuesta
    private $error_id = 0;
    private $error_des = "";
    private $error_detalle = null;
    private $tipo = "json"; //El tipo de respuesta que se espera.
    /*
     * Constructor que acepta el nombre y el area (opcional)
     * */
    public function __construct($n,$a = ""){
        $this -> nombre = $n;
        $this -> area =  $a;
    }
    /*
     * Función de establece el nombre
     * */
    public function setNombre($n){
        $this -> nombre = $n;
        return $this;
    }
    /*
     * Función que devuelve el nombre
     * */
    public function getNombre(){
        return $this -> nombre;
    }
    /*
     * Función de establece el area
     * */
    public function setArea($a){
        $this -> area = $a;
        return $this;
    }
    /*
     * Función que devuelve el area
     * */
    public function getArea(){
        return $this -> area;
    }
    /*
     * Función que hace un set de la respuesta de esta petición propiamente
     * */
    public function setRespuesta($d){
        $this -> respuesta = $d;
        return $this;
    }
    /*
     * Función que hace un get de la respuesta de esta petición propiamente
     * */
    public function getRespuesta(){
        return $this -> respuesta;
    }
    /*
     * Función que limpia las variables de errores
     * */
    public function limpiarErrores(){
        $this -> error_id = 0;
        $this -> error_des = null;
        return $this;
    }
    /*
     * Función que se encarga de establecer los errores
     * */
    public function establecerErrores($id, $des , $detalle = null){
        $this -> error_id       =  $id;
        $this -> error_des      =  $des;
        $this -> error_detalle  =  $detalle; //El detalle es opcional
        return $this;
    }

    /*
     * Función que genera la estructura de la respuesta
     * */
    public function generarEstructura(){
        $this -> estructura = null; //Primero la limpiamos en caso de que otra estructura haya sido generada antes
        $this -> estructura["info"]["nombre"]   =   $this -> nombre;
        $this -> estructura["info"]["area"]     =   $this -> area;
        $this -> estructura["error"]["id"]      =   $this -> error_id;
        $this -> estructura["error"]["des"]     =   $this -> error_des;
        $this -> estructura["error"]["detalle"] =   $this -> error_detalle;
        $this -> estructura["datos"]            =   $this -> respuesta;
        return $this -> estructura;
    }

    public function imprimirRespuesta(){
        $this -> generarEstructura();
        $this -> tipo = strtoupper($this -> tipo);
        switch ($this -> tipo){
            case ("JSON"):
                return response()->json($this -> estructura);
                break;
            default: //El caso predeterminado es igual al JSON
                return response()->json($this -> estructura);
                break;
        }
    }




}
?>