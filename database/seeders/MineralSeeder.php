<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MineralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minerales = [
            [
                'nombre' => 'PLOMO',
                'simbolo' => 'PB',
                'alicuota' => 3.00,
                'conversion' => 2.20462,
            ],
            [
                'nombre' => 'ZING',
                'simbolo' => 'ZN',
                'alicuota' => 3.00,
                'conversion' => 2.20462,
            ],
            [
                'nombre' => 'PLATA',
                'simbolo' => 'AG',
                'conversion' => 32.1507,
                'alicuota' => 3.60,
            ],
            [
                'nombre' => 'COBRE',
                'simbolo' => 'CU',
                'alicuota' => 3.00,
                'conversion' => 2.20462,
            ],
        ];

        foreach ($minerales as $mineral) {
            DB::table('minerales')->updateOrInsert(
                ['simbolo' => $mineral['simbolo']], // condición única para encontrar el registro
                array_merge(
                    $mineral,
                    [
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                )
            );
        }
    }
}
