<?php

use Illuminate\Database\Seeder;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('proveedores')->insert(
            [
                'codigo'                    =>  "01",
                'nombre'                    =>  "COOPEBRISAS R.L.",
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
            ]
        );
        DB::table('proveedores')->insert(
            [
                'codigo'                    =>  "02",
                'nombre'                    =>  "Lácteos San Antonio",
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
            ]
        );

        DB::table('proveedores')->insert(
            [
                'codigo'                    =>  "03",
                'nombre'                    =>  "Productos Lácteos Bella Vista",
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
            ]
        );

        DB::table('proveedores')->insert(
            [
                'codigo'                    =>  "10",
                'nombre'                    =>  "Lácteos La Queserita (CALICANTO)",
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
            ]
        );

        DB::table('proveedores')->insert(
            [
                'codigo'                    =>  "22",
                'nombre'                    =>  "Aguilar y Pereira",
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
            ]
        );

        DB::table('proveedores')->insert(
            [
                'codigo'                    =>  "32",
                'nombre'                    =>  "ITALÁCTEOS LIMITADA",
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
            ]
        );

        DB::table('proveedores')->insert(
            [
                'codigo'                    =>  "37",
                'nombre'                    =>  "Alimentos Veracruz S.A.",
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
            ]
        );




    }
}
