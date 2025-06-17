<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder de roles, permisos y usuarios iniciales
        $this->call([
            RolesYUsuariosSeeder::class,
            // Agrega aquí otros seeders que necesites, por ejemplo:
            // ClientesSeeder::class,
            // ProveedoresSeeder::class,
        ]);
    }
}
