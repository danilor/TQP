<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->bigIncrements('id'); // El ID de la receta
            $table->string('nombre');
            $table->longText('contenido')->nullable();
            $table->longText('productos_relacionados')->nullable(); //Va a ser una lista con los tipos de productos relacionados, separados por coma.
            $table->dateTime('creado')->useCurrent();
            $table->bigInteger('creado_por');
            $table->dateTime('modificado')->nullable();
            $table->bigInteger('modificado_por')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recetas');
    }
}
