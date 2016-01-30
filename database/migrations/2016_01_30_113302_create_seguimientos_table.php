<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     * Los segumimiento son cadenas de mensajes entre usuarios. Son parte del sistema para control de empleados
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("unico",256); //Este campo es un campo único. Lo que quiere decir es que aunque cada seguimiento tiene un id individual, el unico es el mismo para todos los seguimientos de un mismo tipo
            $table->bigInteger("creado_por"); //Quien creó este seguimiento
            $table->bigInteger("asignado_a"); //A quien está asignado este seguimiento
            $table->longText("mensaje")->nullable(); //El mensaje del seguimiento
            $table->timestamp("creado")->nullable(); //Cuando fue creado
            $table->timestamp("cerrado")->nullable(); // Cuando fue cerrado. Si es nulo quiere decir que no lo han cerrado.
            $table->tinyInteger("visto")->default(0); //Indica si ya fue visto por la persona a quien fue asignado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('seguimientos');
    }
}
