<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_productos', function (Blueprint $table) {
            $table->bigIncrements('id'); //EL ID
            $table->bigInteger('usuario');
            $table->dateTime('iniciado'); //La fecha en que se inicia el proceso de registro
            $table->dateTime('finalizado')->nullable(); //La fecha en que se finaliza el registro
            $table->string('proveedor')->nullable(); //El proveedor de este registro
            $table->string('proveedor_nombre')->nullable(); //Almacenamos el nombre solo por si en un futuro cambia, así podemos saber exactamente que nombre tenía en el momento de almacenarse
            $table->longText('formulario')->nullable(); //El formulario completo
            $table->longText('detalle')->nullable(); //El detalle del ingreso
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('registro_productos');
    }
}
