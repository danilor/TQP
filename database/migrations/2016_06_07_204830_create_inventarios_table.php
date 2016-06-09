<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->bigIncrements('id'); //El ID del registro
            $table->bigInteger('usuario'); //El usuario que realiza el movimiento
            $table->string('codigo'); //El código del producto que se está realizando el movimiento
            $table->double('cantidad',16,8)->default(0); //La cantidad del movimiento. Puede ser negativo o positivo
            $table->dateTime('creado'); //La fecha de creación de este registro
            $table->longText('lotes_involucrados')->nullable(); // Una lista de los lotes involucrados en este movimiento. No siempre viene este dato
            $table->longText('vencimientos_involucrados')->nullable(); // Una lista de los vencimientos involucrados en este movimiento. No siempre viene este dato
            $table->longText('detalle')->nullable(); //El detalle de este registro de inventario
            $table->tinyInteger('estado')->default(1); //El estado. Esto es para en un futuro, cerrar registros viejos para que no se tomen en cuenta en los registros y las sumatorias.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inventarios');
    }
}
