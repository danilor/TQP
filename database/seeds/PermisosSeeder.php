<?php

use Illuminate\Database\Seeder;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('permisos')->insert(
            [
                'alias'                   =>  "administrar_usuarios",
                'nombre'                  =>  "Administrar los Usuarios",
            ]
        );
        DB::table('permisos')->insert(
            [
                'alias'                   =>  "administrar_contenido",
                'nombre'                  =>  "Administrar los Contenidos del sitio",
            ]
        );
        DB::table('permisos')->insert(
            [
                'alias'                   =>  "administrar_tipo_productos",
                'nombre'                  =>  "Administrar los Tipos de Productos",
            ]
        );
        DB::table('permisos')->insert(
            [
                'alias'                   =>  "administrar_almacenaje",
                'nombre'                  =>  "Administrar los lugares de Almacenaje",
            ]
        );
        DB::table('permisos')->insert(
            [
                'alias'                   =>  "administrar_procesos",
                'nombre'                  =>  "Administrar los Procesos",
            ]
        );
        DB::table('permisos')->insert(
            [
                'alias'                   =>  "ver_reportes",
                'nombre'                  =>  "Ver reportes",
            ]
        );
        DB::table('permisos')->insert(
            [
                'alias'                   =>  "seguimiento_procesos",
                'nombre'                  =>  "Seguimiento de Procesos y Entregas",
            ]
        );

    }
}
