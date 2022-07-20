<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // El orden importa, primero los usuarios con sus roles y permisos y luego los anuncios
        $this->call(RolePermissionSeeder::class);
        $this->call(AnuncioSeeder::class);
    }
}
