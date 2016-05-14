<?php

use Illuminate\Database\Seeder;

class RecetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('recetas')->insert(
            [
                'nombre'                    =>  "Receta de ejemplo",
                'contenido'                 =>  "<p>Contenido de la receta</p>",
                'productos_relacionados'    =>  "01,02",
                'creado'                    =>  new \DateTime(),
                'creado_por'                =>  1,
            ]
        );

        DB::table('recetas')->insert(
            [
                'nombre'                    =>  "Receta muy rica",
                'contenido'                 =>  "<p>Contenido de la receta</p>",
                'productos_relacionados'    =>  "02",
                'creado'                    =>  new \DateTime(),
                'creado_por'                =>  1,
            ]
        );

        DB::table('recetas')->insert(
            [
                'nombre'                    =>  "Receta con queso",
                'contenido'                 =>  "<p>Contenido de la receta</p>",
                'productos_relacionados'    =>  "03",
                'creado'                    =>  new \DateTime(),
                'creado_por'                =>  1,
            ]
        );

    }
}
