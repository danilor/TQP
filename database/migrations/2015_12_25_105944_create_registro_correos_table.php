<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroCorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_correos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tema',256);
            $table->longText('cuerpo');
            $table->string('plantilla',256);
            $table->string('para_correo',256);
            $table->string('para_nombre',256);
            $table->integer('estado')->nullable()->default(1);
            $table->dateTime("enviado")->nullable();
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
        Schema::drop('registro_correos');
    }
}
