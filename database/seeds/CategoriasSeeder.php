<?php

use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('categoria_productos')->insert([
            'nombre'                    => "Terminado-Proveedor",
            'created_at'                => $fecha,
            'updated_at'                => $fecha,
        ]);
        DB::table('categoria_productos')->insert([
            'nombre'                    => "Terminado Tiqueso",
            'created_at'                => $fecha,
            'updated_at'                => $fecha,
        ]);
        DB::table('categoria_productos')->insert([
            'nombre'                    => "Producto en Proceso",
            'created_at'                => $fecha,
            'updated_at'                => $fecha,
        ]);




    }
}
