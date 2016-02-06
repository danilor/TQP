<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VidaUtil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_productos', function (Blueprint $table) {
            $table->integer("vida_util")->default(0); //La vida útil del tipo de producto
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_productos', function (Blueprint $table) {
            //
        });
    }
}
