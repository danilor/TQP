<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearUsuariosRoles extends Migration
{
    /**
     *
     * La table de usuarios roles no está asignada a ningún Modelo de Eloquent debido a que es solo una tabla para relacionar usuarios con roles y no hay necesidad de
     * tener un objeto específico de ello. Esto no quiere decir que la tabla no vaya a ser utilizada relacionalmente.
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("id_usuario");
            $table->bigInteger("id_rol");
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
        Schema::drop('usuarios_roles');
    }
}
