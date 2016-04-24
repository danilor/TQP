<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('roles')->insert(
            [
                'nombre'                        =>  "Administrador de Planta",
                'permisos'                      =>  "",
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );
        DB::table('roles')->insert(
            [
                'nombre'                        =>  "Conductor",
                'permisos'                      =>  "",
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );
        DB::table('roles')->insert(
            [
                'nombre'                        =>  "Programador",
                'permisos'                      =>  "administrar_usuarios,",
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );
        DB::table('roles')->insert(
            [
                'nombre'                        =>  "Administrador de redes",
                'permisos'                      =>  "",
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );
        DB::table('roles')->insert(
            [
                'nombre'                        =>  "Misceláneo",
                'permisos'                      =>  "",
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );

        DB::table('roles')->insert(
            [
                'nombre'                        =>  "Invitado",
                'permisos'                      =>  "",
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );




    }
}
