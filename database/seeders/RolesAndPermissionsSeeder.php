<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'usuarios' => ['ver', 'crear', 'editar', 'eliminar'],
            'cargas'   => ['ver', 'crear', 'editar', 'eliminar'],
            'laboratorio' => ['ver', 'crear', 'editar', 'eliminar'],
            'liquidaciones' => ['ver', 'crear', 'editar', 'eliminar'],
        ];

      
        foreach ($permissions as $modulo => $acciones) {
            foreach ($acciones as $accion) {
                Permission::firstOrCreate(['name' => "$accion $modulo"]);
            }
        }

        $rolesWithPermissions = [
            'administrador' => Permission::all()->pluck('name'), // todos
            'pesaje' => [
                'ver cargas',
                'crear cargas',
            ],
            'laboratorio' => [
                'ver laboratorio',
                'crear laboratorio',
                'editar laboratorio',
                'eliminar laboratorio',
            ],
            'liquidacion' => [
                'ver liquidaciones',
                'crear liquidaciones',
                'editar liquidaciones',
                'eliminar liquidaciones',
            ],
            'exportador' => [
                // ej: 'ver cargas'
            ],
        ];

        foreach ($rolesWithPermissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            if (is_array($perms)) {
                $role->syncPermissions($perms);
            } else {
                $role->syncPermissions($perms); 
            }
        }
    }
}
