<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            //Campos principales
            $table->bigIncrements('id');
            $table->string("usuario",255);
            $table->string("contrasena",512);
            $table->string("cedula",255);
            $table->string("nombre",255);
            $table->string("apellido",255);
            $table->string("apodo",255)->nullable();
            $table->string("correo",255);

            //Datos adicionales
            $table->string("sexo",10)->nullable();
            $table->string("foto",255);

            //Direcciones y extras
            $table->string("telefono",255);
            $table->string("celular",255);
            $table->string("direccion",255);
            $table->string("direccion2",255);

            //Notas
            $table->longText("caracteristicas")->nullable();
            $table->longText("notas")->nullable();

            //Estados y booleanos
            $table->tinyInteger("activo")->default(1);
            $table->tinyInteger("super_administrador")->default(0);

            //Fechas
            $table->dateTime("fecha_nacimiento")->nullable();
            $table->dateTime("ultimo_ingreso")->nullable();
            $table->dateTime("ultimo_cambio_contrasena")->nullable();
            $table->rememberToken()->nullable();
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
        Schema::drop('usuarios');
    }
}
