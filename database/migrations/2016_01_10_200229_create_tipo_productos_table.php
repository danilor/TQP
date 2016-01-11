<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_productos', function (Blueprint $table) {
            $table->string('codigo',10); //El código no se puede generar automáticamente debido a que son códigos que ya funcionan en la empresa a nivel general. Y tienen que llevar los 0 por delante, por ello el código tiene que ser un tipo string
            $table->string('nombre',100);
            $table->string('foto',512); //La foto principal. Eso no quiere decir que no puedan haber más fotos para un tipo de producto para el caso de mostrar en el sitio
            $table->longText('detalle',512);
            $table->longText('caracteristicas',512);
            $table->string('unidad',30)->nullable(); //Indica la unidad con que se vende usualmente, por ejemplo kilogramos. No es requerido
            $table->tinyInteger("mostrar")->default(0); //Indica si este producto se va a mostrar en el sitio público (o página principal)
            $table->tinyInteger("estado")->default(1); //Indica si este producto está habilitado o no
            $table->timestamps();
            $table->primary("codigo"); //Un string solamente puede ser llave primaria en MySQL si es mejor de 50 caracteres
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
        Schema::drop('tipo_productos');
    }
}
