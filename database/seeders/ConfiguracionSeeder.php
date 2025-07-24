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
        DB::table('configuraciones')->insert([
            'nombre_empresa' => 'Empresa de Minerales',
            'cotizacion_dolar' => 6.96,  // Puedes poner el valor inicial que quieras
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
