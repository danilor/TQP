<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("nombre"); //El nombre de la categoría
            $table->string("detalles")->nullable(); //Detalles de la categoría
            $table->string("extra")->nullable(); //Extra información
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
        Schema::drop('categoria_productos');
    }
}
