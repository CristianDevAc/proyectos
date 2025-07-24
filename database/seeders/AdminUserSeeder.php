<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Buscar o crear el usuario administrador
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        // Asignar el rol administrador (debes tenerlo creado con RolesAndPermissionsSeeder)
        $user->assignRole('administrador');

        // Mensaje en consola
        $this->command->info('Usuario administrador creado: admin@example.com / admin123');
    }
}