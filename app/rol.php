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
}
