<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnadirEstadoSeguimientoYLatLong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seguimientos', function (Blueprint $table) {
            $table->tinyInteger("estado")->nullable()->default(1)->after("mensaje");
            $table->string("longitud")->nullable()->after("visto");
            $table->string("latitud")->nullable()->after("visto");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seguimientos', function (Blueprint $table) {
            //
        });
    }
}
