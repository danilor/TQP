<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->bigIncrements('id'); // El ID del mensaje
            $table->string('tema');
            $table->longText('mensaje');
            $table->string('nombre');
            $table->string('correo');
            $table->string('telefono')->nullable();
            $table->string('compania')->nullable();
            $table->dateTime('creado')->useCurrent();
            $table->string('ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mensajes');
    }
}
