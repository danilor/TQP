<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->string('codigo'); //El código del proveedor
            $table->string("nombre"); //El nombre del proveedor
            $table->string("detalle")->nullable(); // El detalle del proveedor. No obligatorio
            $table->timestamps();
            $table->primary("codigo"); //Ponemos el proveedor como primario
            $table->index("codigo");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proveedores');
    }
}
