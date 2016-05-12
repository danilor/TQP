<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->bigIncrements('id'); // El ID del proceso
            $table->string('unico',256); // ID único. Este es generado para el proceso
            $table->dateTime('iniciado_fecha')->nullable(); // La fecha en que es iniciado (incluye hora)
            $table->bigInteger('iniciado_por')->nullable(); // El usuario quien inició el proceso
            $table->dateTime('finalizado_fecha')->nullable(); // La fecha en que es finalizado (incluye hora)
            $table->bigInteger('finalizado_por')->nullable(); // El usuario quien finalizó el proceso
            $table->longText('productos_proceso')->nullable(); // Una lista de los códigos de productos que están en proceso. Van separados por coma (,)
            $table->tinyInteger('estado')->default(0); // El estado del proceso. 0 para indicar inactivo, y un 1 para indicar activo.
            $table->longText('detalle')->nullable(); // Algún detalle que se quiera añadir al proceso
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('procesos');
    }
}
