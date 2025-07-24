<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CentroAcopio;
use App\Models\Plataforma;

class CentroAcopioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Crear el centro de acopio
        $centro = CentroAcopio::create([
            'nombre' => 'CENTRO DE ACOPIO',
            'codigo' => 'CA1',
            'descripcion' => 'CENTRO DE ACOPIO PRINCIPAL',
        ]);

        // Crear 5 plataformas asociadas
        for ($i = 1; $i <= 5; $i++) {
            Plataforma::create([
                'nombre' => 'PLATAFORMA ' . $i,
                'codigo' => 'P' . $i,
                'descripcion' => '',
                'centro_acopio_id' => $centro->id,
            ]);
        }
    }
}
