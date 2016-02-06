<?php

use Illuminate\Database\Seeder;

class TiposSeeder extends Seeder
{
    /**
     * Se introducen los tipos de productos básicos
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "01",
                'nombre'                    =>  "Semiduro",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  30,
            ]
        );


        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "02",
                'nombre'                    =>  "Turrialba",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  20,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "03",
                'nombre'                    =>  "Mozzarella",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  30,
            ]
        );
        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "04",
                'nombre'                    =>  "Palmito",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  45,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "05",
                'nombre'                    =>  "Ahumado",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  30,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "06",
                'nombre'                    =>  "Cremoso",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  45,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "07",
                'nombre'                    =>  "Natilla",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  45,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "09",
                'nombre'                    =>  "Imitación de Amarillo",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  0,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  -1, //-1 indica que es segun proveedor
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "10",
                'nombre'                    =>  "Imitación de blanco",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  0,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  -1,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "11",
                'nombre'                    =>  "Cuajada",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  22,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "12",
                'nombre'                    =>  "Bugaces",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  60,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "14",
                'nombre'                    =>  "Chontaleño",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  60,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "15",
                'nombre'                    =>  "Salsa Cheddar",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  60,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "16",
                'nombre'                    =>  "Parmesano",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  -1,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "20",
                'nombre'                    =>  "Semiduro de búfala",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  30,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "22",
                'nombre'                    =>  "Queso crema",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  45,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "23",
                'nombre'                    =>  "Deshidratado",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  0,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  90,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "24",
                'nombre'                    =>  "Queso fundido con sal",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  0,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  30,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "25",
                'nombre'                    =>  "Queso fundido sin sal",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  0,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  30,
            ]
        );



        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "28",
                'nombre'                    =>  "Turrialba para fundir",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  1,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  20,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "29",
                'nombre'                    =>  "Semiduro cultivado",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  0,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  30,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "32",
                'nombre'                    =>  "Reproceso",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  0,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  8,
            ]
        );

        DB::table('tipo_productos')->insert(
            [
                'codigo'                    =>  "39",
                'nombre'                    =>  "Devolución",
                'foto'                      =>  "",
                'detalle'                   =>  "",
                'caracteristicas'           =>  "",
                'mostrar'                   =>  0,
                'estado'                    =>  1,
                'created_at'                =>  $fecha,
                'updated_at'                =>  $fecha,
                'vida_util'                 =>  8,
            ]
        );




    }
}
