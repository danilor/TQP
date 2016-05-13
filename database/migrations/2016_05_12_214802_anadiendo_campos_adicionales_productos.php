<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnadiendoCamposAdicionalesProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->tinyInteger('producto_tiqueso')->default(0); // Indica siel producto proviene de los procesos de tiqueso. Predeterminado se obtiene el valor de 0.
            $table->bigInteger('proceso_padre')->default(0); // El del proceso del que fue obtenido
            $table->longText('materias_primas')->nullable(); // Una lista de códigos de materias primas separadas por coma (,)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            //
        });
    }
}
