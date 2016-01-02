<?php

use Illuminate\Database\Seeder;

class RolesUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('usuarios_roles')->insert(
            [
                'id_usuario'                    =>  1, //Danilo
                'id_rol'                        =>  3, //Programador
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );
        DB::table('usuarios_roles')->insert(
            [
                'id_usuario'                    =>  1, //Danilo
                'id_rol'                        =>  4, //Redes
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );
        DB::table('usuarios_roles')->insert(
            [
                'id_usuario'                    =>  2, //Marvin
                'id_rol'                        =>  3, //Programador
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );

        DB::table('usuarios_roles')->insert(
            [
                'id_usuario'                    =>  2, //Marvin
                'id_rol'                        =>  4, //Redes
                'created_at'                    =>  $fecha,
                'updated_at'                    =>  $fecha,
            ]
        );




    }
}
