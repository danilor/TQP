<?php
namespace App\clases;
use Config;
use App;
use Request;
use Response;
use View;
use DB;
class Comunes{
    public static function reglas($name,$required = false, $extra = ""){
        $mainR = Config::get('reglas.'.$name);
        if($required){ $mainR = "required|".$mainR; }
        if(strlen($extra)>0){ $mainR .= "|".$extra; }
        return $mainR;
    }

    public static function enviar404(){
        return Response::make(View::make('errores/404'), 404);
        dd("Pàgina 404");
    }
}
?>