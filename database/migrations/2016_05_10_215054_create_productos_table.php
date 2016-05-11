<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id'); //El ID interno del producto
            $table->string('codigo_tipo',10);
            $table->string('codigo_proveedor',10);
            $table->string('nombre_proveedor'); //Almacenamos el nombre del proveedor por si es el caso de que en un futuro se cambia el código, nosotros sepamos para cual proveedor era al momento de registrarlo
            $table->integer('dia_juliano'); //
            $table->integer('tanda');
            $table->string('codigo',10);
            $table->dateTime('vencimiento'); // La fecha de vencimiento. Aunque se calcula, se puede modificar si se quiere.
            $table->float('unidades') -> nullable(); //La cantidad de unidades entrantes, si el producto es por peso entonces es por kilogramos
            $table->float('humedad') -> nullable(); // La humedad con que entra el producto
            $table->longText('detalle')->nullable(); //Algún detalle que se le quiera introducir al producto.
            $table->tinyInteger('estado')->dcefault(1); // El estado del producto. 1 debería indicar que el producto sigue en la planta o en manos de TIQUESO, el 0 debería indicar que está afuera. Esto para limitar las búsquedas futuras.
            $table->bigInteger('creado_por'); //El usuario que registra el producto
            $table->dateTime('registrado'); //El momento en que fue registrado
            $table->dateTime('modificado'); //El momento en que fue registrado
            /*Los siguientes campos son para hacerle un borrado lógico a los productos*/
            $table->tinyInteger('borrado')->default(0); //Indica si el producto aparece como borrado
            $table->dateTime('borrado_fecha')->nullable(); //El momento en que fue registrado
            $table->bigInteger('borrado_por')->default(0)->nullable(); //La persona que lo borró
            $table->index('codigo'); //Ponemos el código como indexable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('productos');
    }
}
