<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contribucion;

class ContribucionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $contribuciones = [
            [
                'nombre' => 'COMIBOL',
                'descripcion' => 'CORPORACIÓN MINERA DE BOLIVIA',
                'inicial' => 1,
                'valor' => 1.00
            ],
            [
                'nombre' => 'CNS',
                'descripcion' => 'CAJA NACIONAL DE SALUD',
                'inicial' => 1,
                'valor' => 1.80
            ],
            [
                'nombre' => 'FEDECOMIN',
                'descripcion' => 'FEDERACIÓN DE COOPERATIVAS MINERAS DE POTOSÍ R.L.',
                'inicial' => 1,
                'valor' => 1.00
            ],
            [
                'nombre' => 'FENCOMIN',
                'descripcion' => 'FEDERACIÓN DE COOPERATIVAS MINERAS DE BOLIVIA R.L.',
                'inicial' => 1,
                'valor' => 0.40
            ],
        ];

        foreach ($contribuciones as $item) {
            Contribucion::updateOrCreate($item);
        }
    }
}
