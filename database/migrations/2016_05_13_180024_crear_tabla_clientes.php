<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('fax')->nullable();
            $table->timestamp('creado')->useCurrent();// crear columna creado con la hora actual del servidor de la base de datos como predeterminado
            $table->timestamp('actualizado');// crear columna actualizado con la hora actual del servidor de la base de datos como predeterminado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clientes');
    }
}
