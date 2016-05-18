<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlmacenajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacenajes', function (Blueprint $table) {
            $table->bigIncrements('id'); //El ID del centro de almacenaje
            $table->string('nombre'); //El Nombre del almacenaje
            $table->text('ubicacion')->nullable(); //La ubicación del centro de almacenaje
            $table->tinyInteger('tipo')->default(0); // El tipo refiérase a un 0 para statico y un 1 para móvil o vehículo
            $table->double('temperatura')->nullable(); //La temperatura del centro de almacenaje
            $table->string('placa')->nullable(); //La placa en caso de que sea de tipo vehículo
            $table->dateTime('creado'); //La fecha de creación
            $table->bigInteger('creado_por'); //El ID del usuario que lo creó
            $table->dateTime('modificado')->nullable(); //Fecha de modificación
            $table->bigInteger('modificado_por')->nullable(); //El ID de la última persona que lo modificó
            $table->tinyInteger('estado')->default(1);
            $table->tinyInteger('borrado')->default(0);
            $table->bigInteger('borrado_por')->nullable(); //El ID de la última persona que lo modificó
            $table->dateTime('borrado_fecha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('almacenajes');
    }
}
