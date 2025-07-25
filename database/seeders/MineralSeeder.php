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
        DB::table('minerales')->updateOrInsert([
            [
                'nombre' => 'PLOMO',
                'simbolo' => 'PB',
                'alicuota' => 3.00,
                'conversion' => 2.20462,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'ZING',
                'simbolo' => 'ZN',
                'alicuota' => 3.00,
                'conversion' => 2.20462,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'PLATA',
                'simbolo' => 'AG',
                'conversion' =>32.1507,
                'alicuota' => 3.60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'COBRE',
                'simbolo' => 'CU',
                'alicuota' => 3.00,
                'conversion' => 2.20462,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
