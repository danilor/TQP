<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearRegistroIngreso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_ingreso', function (Blueprint $table) {
            $table->bigIncrements('id'); //El ID del registro
            $table->dateTime('fecha'); //La fecha del registro
            $table->string('usuario')->nullable(); //El Usuario con que intentan ingresar
            $table->bigInteger('usuario_id')->nullable(); //El usuario ID en caso de éxito
            $table->tinyInteger('estado'); //0 para indicar que no fue exitoso, 1 para indicar que si lo fue.
            $table->string('lat')->nullable(); // La latitud del registro
            $table->string('lon')->nullable(); //La longitud del registro
            $table->string('ip')->nullable(); //La ip del registro
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('registro_ingreso');
    }
}
