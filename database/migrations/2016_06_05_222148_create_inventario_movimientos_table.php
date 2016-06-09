<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_movimientos', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('codigo'); //El código de producto
            $table->bigInteger('usuario'); //El usuario que inicia este movimiento
            $table->double('cantidad',16,8); //La cantidad de unidades que se realizaron para este movimiento
            $table->text('detalle')->nullable(); //El detalle del movimiento
            $table->dateTime('fecha')->useCurrent(); //La fecha de este movimiento
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inventario_movimientos');
    }
}
