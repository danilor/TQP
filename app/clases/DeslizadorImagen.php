<?php

namespace App\clases;
use Config;
use App;
use Faker\Provider\zh_TW\DateTime;
use Mockery\CountValidator\Exception;
use Request;
use Response;
use View;
use DB;

use Illuminate\Database\Eloquent\Model;

class DeslizadorImagen extends Model {
    protected $table="deslizadores_imagenes";
}