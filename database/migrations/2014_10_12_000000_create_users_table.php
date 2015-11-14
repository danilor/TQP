<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
		$table->string('cedula')->nullable();
            $table->string('nombre');
	    $table->string('apellido');
            $table->string('correo')->unique();
            $table->string('contrasena', 60);
		$table->integer('administrador')->default(0);
		$table->integer('activo')->default(1);
		$table->timestamp('ultimo_ingreso')->nullable();
		$table->timestamp('fecha_inicio')->nullable();
		//Estas van en inglés porque son predeterminadas del framework
            $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
    }
}
