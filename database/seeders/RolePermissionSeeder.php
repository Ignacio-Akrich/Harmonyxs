<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset caché roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crea los permisos
        Permission::create(['name' => 'editar anuncio']);
        Permission::create(['name' => 'eliminar anuncio']);
        Permission::create(['name' => 'crear anuncio']);
        Permission::create(['name' => 'ver anuncio']);
        Permission::create(['name' => 'editar rol']);
        Permission::create(['name' => 'eliminar rol']);
        Permission::create(['name' => 'crear rol']);
        Permission::create(['name' => 'ver rol']);
        Permission::create(['name' => 'acceso administracion']);

        // Crea los roles y asigna los permisos (código provisional)
        $artista = Role::create(['name' => 'Artista']);
        $artista->givePermissionTo(['editar anuncio', 'eliminar anuncio', 'crear anuncio', 'ver anuncio', 'ver rol']);

        $banda = Role::create(['name' => 'Banda']);
        $banda->givePermissionTo(['editar anuncio', 'eliminar anuncio', 'crear anuncio', 'ver anuncio', 'ver rol']);

        $superadmin = Role::create(['name' => 'Super Admin']);
        $superadmin->givePermissionTo(Permission::all());

        // Crea los superadmins de Harmonyxs
        $userSuperAdmin = User::create([
            'name' => 'Daniel Maestre',
            'email' => 'dmaestre.empleo@gmail.com',
            'password' => Hash::make('123456'),
            'music_genre' => 'Heavy metal',
            'age' => '25',
            'lat'=>39.5852,
            'lng'=>2.6784
        ]);
        $userSuperAdmin->assignRole($superadmin);

        $userSuperAdmin2 = User::create([
            'name' => 'Maite Ladaria',
            'email' => 'maiteladaria@gmail.com',
            'password' => Hash::make('123456'),
            'music_genre' => 'Pop',
            'age' => '26',
            'lat'=>39.5831,
            'lng'=>2.6693
        ]);
        $userSuperAdmin2->assignRole($superadmin);

        $userSuperAdmin3 = User::create([
            'name' => 'Ignacio Akrich',
            'email' => 'jakrich@cifpfbmoll.eu',
            'password' => Hash::make('123456'),
            'music_genre' => 'Rock',
            'age' => '26',
            'lat'=>39.5695,
            'lng'=>2.6500
        ]);
        $userSuperAdmin3->assignRole($superadmin);

        $roleBandUsers= User::factory(5)->create();
        $roleBand = Role::findByName('Banda');
        $roleBand->users()->attach($roleBandUsers);

        $roleMusicianUsers= User::factory(5)->create();
        $roleMusicians = Role::findByName('Artista');
        $roleMusicians->users()->attach($roleMusicianUsers);
    }
}
