<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuraciones')->updateOrInsert(
            ['nombre_empresa' => 'Empresa de Minerales'], // condición para buscar
            [
                'cotizacion_dolar' => 6.96,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
