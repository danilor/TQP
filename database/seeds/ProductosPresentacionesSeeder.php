<?php

use Illuminate\Database\Seeder;

class ProductosPresentacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '02',
                'detalle'   =>  '2 Kg',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '03',
                'detalle'   =>  '3 Kg',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '05',
                'detalle'   =>  '5 Kg',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '10',
                'detalle'   =>  '100 unidades/100 g/10 kg',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '12',
                'detalle'   =>  '12 unidades/125 g',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '20',
                'detalle'   =>  '200 g/ 2 unidades/ 2 kg',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '25',
                'detalle'   =>  '250 g',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '30',
                'detalle'   =>  '300 g',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '40',
                'detalle'   =>  '400 g/ 40 unidades',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '50',
                'detalle'   =>  '500 g',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '75',
                'detalle'   =>  '1 Kg',
                'creado'    =>  $fecha,
            ]
        );
        DB::table('producto_presentaciones')->insert(
            [
                'codigo'    =>  '80',
                'detalle'   =>  '80 g',
                'creado'    =>  $fecha,
            ]
        );
    }
}
