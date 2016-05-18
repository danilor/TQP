<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialAlmacenajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_almacenajes', function (Blueprint $table) {
            $table->bigIncrements('id'); //El ID del registro
            $table->bigInteger('producto_id');
            $table->string('producto_codigo');
            $table->bigInteger('almacenaje_id');
            $table->dateTime('fecha_movimiento');
            $table->bigInteger('movido_por'); //El ID del usuario quien movió este producto a este centro de almacenaje
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('historial_almacenajes');
    }
}
