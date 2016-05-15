<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearUsuarioProceso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_proceso', function (Blueprint $table) {
            $table->bigIncrements('id'); //El ID de la relación
            $table->bigInteger('usuario_id'); //El ID del usuario
            $table->bigInteger('proceso_id'); //El ID del proceso
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuario_proceso');
    }
}
