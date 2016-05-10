<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UsuariosSeeder::class); //Añade datos básicos de usuarios a la tabla de usuarios
        $this->call(PermisosSeeder::class); //Añade datos básicos de permisos a la table de permisos
        $this->call(RolesSeeder::class); //Añade datos básicos de roles a la table de roles
        $this->call(RolesUsuariosSeeder::class); //Asigna los usuarios de ejemplo a varios roles de ejemplo
        $this->call(TiposSeeder::class); //Asigna los tipos de productos iniciales
        $this->call(CategoriasSeeder::class); //Asigna las categorías
        $this->call(ProveedoresSeeder::class); //Asigna los proveedores
        Model::reguard();
    }
}
