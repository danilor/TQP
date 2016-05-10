<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarMasCamposProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->string("telefono",10)->nullable()->after('detalle');
            $table->string("correo",50)->nullable()->after('telefono');
            $table->string("direccion",500)->nullable()->after('correo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proveedores', function ($table) {
            $table->dropColumn('telefono');
            $table->dropColumn('correo');
            $table->dropColumn('direccion');
        });
    }
}
