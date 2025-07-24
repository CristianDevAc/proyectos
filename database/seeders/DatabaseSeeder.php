<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            CentroAcopioSeeder::class,
            AdminUserSeeder::class,
            MunicipioSeeder::class,
            MineralSeeder::class,
            ContribucionesSeeder::class,
            CotizacionSeeder::class,
            ConfiguracionSeeder::class,
        ]);
    }
}
