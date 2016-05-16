<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id'); //El ID del banner
            $table->string('url');
            $table->string('nombre'); //El nombre solo va como referencia
            $table->dateTime('creado')->useCurrent();
            $table->bigInteger('creado_por'); //El ID del usuario que lo creó
            $table->integer('orden'); //Un ID indicando el orden
            $table->tinyInteger('activo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('banners');
    }
}
