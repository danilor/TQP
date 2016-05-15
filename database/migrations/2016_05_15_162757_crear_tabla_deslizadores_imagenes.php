<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDeslizadoresImagenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deslizadores_imagenes', function (Blueprint $table) {    
            $table->bigIncrements('id');
            $table->string('url');
            $table->string('ancho')->nullable();
            $table->string('alto')->nullable();
            $table->timestamp('creado')->useCurrent();// crear columna creado con la hora actual del servidor de la base de datos como predeterminado
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deslizadores_imagenes');
    }
}
