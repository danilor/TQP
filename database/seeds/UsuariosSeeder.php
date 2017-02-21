<?php

use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha = new \DateTime();
        DB::table('usuarios')->insert([
            'usuario'                   =>  "dramirez",
            'password'                  =>  Hash::make('123456'),
            'nombre'                    => 'Danilo',
            'apellido'                  => 'Ramírez',
            'apodo'                     => '',
            'correo'                    => 'daniloramirez.cr@gmail.com',
            'sexo'                      => 'm',
            'foto'                      => '',
            'telefono'                  => '22194636',
            'celular'                   => '88975131',
            'direccion'                 => 'Villa Nueva, Gravilias, Desamparados',
            'direccion2'                => '75 metros sur de la Iglesia Católica de Villa Nueva',
            'caracteristicas'           => 'Programador',
            'notas'                     => 'Desarrollador',
            'activo'                    => 1,
            'super_administrador'       => 1,
            'fecha_nacimiento'          => null,
            'ultimo_ingreso'            => null,
            'ultimo_cambio_contrasena'  => null,
            'created_at'                => $fecha,
            'updated_at'                => $fecha,

        ]);

        DB::table('usuarios')->insert([
            'usuario'                   =>  "celizondo",
            'password'                  =>  Hash::make('123456'),
            'nombre'                    => 'Carlos',
            'apellido'                  => 'Elizondo',
            'apodo'                     => '',
            'correo'                    => 'celizondo@tiqueso.com',
            'sexo'                      => 'm',
            'foto'                      => '',
            'telefono'                  => '000000',
            'celular'                   => '0000',
            'direccion'                 => 'NA',
            'direccion2'                => 'NA',
            'caracteristicas'           => 'NA',
            'notas'                     => 'NA',
            'activo'                    => 1,
            'super_administrador'       => 1,
            'fecha_nacimiento'          => null,
            'ultimo_ingreso'            => null,
            'ultimo_cambio_contrasena'  => null,
            'created_at'                => $fecha,
            'updated_at'                => $fecha,

        ]);


    }
}
