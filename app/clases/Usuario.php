<?php
namespace App\clases;
use Config;
use App;
use Mockery\CountValidator\Exception;
use Request;
use Response;
use View;
use DB;
class Usuario{

    private $elementos = ["id","nombre","apellido","correo","usuario","cedula","apodo","sexo","foto"];

    public function __construct($usuario){
        foreach($this->elementos AS $key => $u){
            try{
                $this->$u = $usuario->$u;
            }catch(\Exception $e){
                    dd($e);
            }

        }
    }

    public function obtenerNombreCompleto(){
        return "$this->nombre $this->apellido";
    }

}
?>