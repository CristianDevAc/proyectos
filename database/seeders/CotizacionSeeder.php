<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cotizacion;

class CotizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $mineralIds = [
            1 => 'PLOMO',
            2 => 'ZINC',
            3 => 'PLATA',
            4 => 'COBRE'
        ];

        $datos = [

            // AÑO 2023
            // ---- Enero 2023 ----
            [ 'gestion' => 2023, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 1.02 ], // PLOMO L.F. 1,02
            [ 'gestion' => 2023, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.38 ], // ZINC L.F. 1,38
            [ 'gestion' => 2023, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 23.65 ], // PLATA O.T. 23,65
            [ 'gestion' => 2023, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.78 ], // COBRE L.F. 3,78
            [ 'gestion' => 2023, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.41 ], // ZINC L.F. 1,41
            [ 'gestion' => 2023, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 23.78 ], // PLATA O.T. 23,78
            [ 'gestion' => 2023, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 1.02 ], // PLOMO L.F. 1,02
            [ 'gestion' => 2023, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.93 ], // COBRE L.F. 3,93
            [ 'gestion' => 2023, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.55 ], // ZINC L.F. 1,55
            [ 'gestion' => 2023, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 23.72 ], // PLATA O.T. 23,72
            [ 'gestion' => 2023, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.99 ], // PLOMO L.F. 0,99
            [ 'gestion' => 2023, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.19 ], // COBRE L.F. 4,19
            [ 'gestion' => 2023, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.45 ], // ZINC L.F. 1,45
            [ 'gestion' => 2023, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 22.56 ], // PLATA O.T. 22,56
            [ 'gestion' => 2023, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.95 ], // PLOMO L.F. 0,95
            [ 'gestion' => 2023, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.07 ], // COBRE L.F. 4,07
            // Segunda quincena marzo 2023
            [ 'gestion' => 2023, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.39 ], // ZINC
            [ 'gestion' => 2023, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 21.33 ], // PLATA
            [ 'gestion' => 2023, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.95 ], // PLOMO
            [ 'gestion' => 2023, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.05 ], // COBRE

            // Primera quincena abril 2023
            [ 'gestion' => 2023, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.33 ], // ZINC
            [ 'gestion' => 2023, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 22.84 ], // PLATA
            [ 'gestion' => 2023, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.97 ], // PLOMO
            [ 'gestion' => 2023, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.01 ], // COBRE

            // Segunda quincena abril 2023
            [ 'gestion' => 2023, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.29 ], // ZINC
            [ 'gestion' => 2023, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 24.93 ], // PLATA
            [ 'gestion' => 2023, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.97 ], // PLOMO
            [ 'gestion' => 2023, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.04 ], // COBRE

            // Primera quincena mayo 2023
            [ 'gestion' => 2023, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.23 ], // ZINC
            [ 'gestion' => 2023, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 25.05 ], // PLATA
            [ 'gestion' => 2023, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.98 ], // PLOMO
            [ 'gestion' => 2023, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.96 ], // COBRE

            // Segunda quincena mayo 2023
            [ 'gestion' => 2023, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.18 ], // ZINC
            [ 'gestion' => 2023, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 25.02 ], // PLATA
            [ 'gestion' => 2023, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.96 ], // PLOMO
            [ 'gestion' => 2023, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.83 ], // COBRE

             // Junio 2023 - Primera Quincena
            ['gestion' => 2023, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.93], // PLOMO
            ['gestion' => 2023, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.08], // ZINC
            ['gestion' => 2023, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 23.43], // PLATA
            ['gestion' => 2023, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.66], // COBRE

            // Junio 2023 - Segunda Quincena
            ['gestion' => 2023, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.94], // PLOMO
            ['gestion' => 2023, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.07], // ZINC
            ['gestion' => 2023, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 23.79], // PLATA
            ['gestion' => 2023, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.78], // COBRE

            // Julio 2023 - Primera Quincena
            ['gestion' => 2023, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.98], // PLOMO
            ['gestion' => 2023, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.08], // ZINC
            ['gestion' => 2023, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 23.03], // PLATA
            ['gestion' => 2023, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.82], // COBRE

            // Julio 2023 - Segunda Quincena
            ['gestion' => 2023, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.95], // PLOMO
            ['gestion' => 2023, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.08], // ZINC
            ['gestion' => 2023, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 23.28], // PLATA
            ['gestion' => 2023, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.80], // COBRE
            // Agosto 2023 - Primera Quincena
            ['gestion' => 2023, 'mes' => 8, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.96], // PLOMO
            ['gestion' => 2023, 'mes' => 8, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.10], // ZINC
            ['gestion' => 2023, 'mes' => 8, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 24.73], // PLATA
            ['gestion' => 2023, 'mes' => 8, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.86], // COBRE

            // Agosto 2023 - Segunda Quincena
            ['gestion' => 2023, 'mes' => 8, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.96], // PLOMO
            ['gestion' => 2023, 'mes' => 8, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.11], // ZINC
            ['gestion' => 2023, 'mes' => 8, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 23.25], // PLATA
            ['gestion' => 2023, 'mes' => 8, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.81], // COBRE

            // Septiembre 2023 - Primera Quincena
            ['gestion' => 2023, 'mes' => 9, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.99], // PLOMO
            ['gestion' => 2023, 'mes' => 9, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.06], // ZINC
            ['gestion' => 2023, 'mes' => 9, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 23.63], // PLATA
            ['gestion' => 2023, 'mes' => 9, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.77], // COBRE

            // Septiembre 2023 - Segunda Quincena
            ['gestion' => 2023, 'mes' => 9, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 1.03], // PLOMO
            ['gestion' => 2023, 'mes' => 9, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.12], // ZINC
            ['gestion' => 2023, 'mes' => 9, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 23.30], // PLATA
            ['gestion' => 2023, 'mes' => 9, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.79], // COBRE

            // Octubre 2023 - Primera Quincena
            ['gestion' => 2023, 'mes' => 10, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 1.01], // PLOMO
            ['gestion' => 2023, 'mes' => 10, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.14], // ZINC
            ['gestion' => 2023, 'mes' => 10, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 23.17], // PLATA
            ['gestion' => 2023, 'mes' => 10, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.70], // COBRE

            // Octubre 2023 - Segunda Quincena
            ['gestion' => 2023, 'mes' => 10, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.97], // PLOMO
            ['gestion' => 2023, 'mes' => 10, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.12], // ZINC
            ['gestion' => 2023, 'mes' => 10, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 21.57], // PLATA
            ['gestion' => 2023, 'mes' => 10, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.60], // COBRE
             // Noviembre 2023 - Primera Quincena
            ['gestion' => 2023, 'mes' => 11, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.97], // PLOMO
            ['gestion' => 2023, 'mes' => 11, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.10], // ZINC
            ['gestion' => 2023, 'mes' => 11, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 22.95], // PLATA
            ['gestion' => 2023, 'mes' => 11, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.60], // COBRE

            // Noviembre 2023 - Segunda Quincena
            ['gestion' => 2023, 'mes' => 11, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.98], // PLOMO
            ['gestion' => 2023, 'mes' => 11, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.16], // ZINC
            ['gestion' => 2023, 'mes' => 11, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 22.67], // PLATA
            ['gestion' => 2023, 'mes' => 11, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.66], // COBRE

            // Diciembre 2023 - Primera Quincena
            ['gestion' => 2023, 'mes' => 12, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 1.00], // PLOMO
            ['gestion' => 2023, 'mes' => 12, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.15], // ZINC
            ['gestion' => 2023, 'mes' => 12, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 24.11], // PLATA
            ['gestion' => 2023, 'mes' => 12, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.75], // COBRE

            // Diciembre 2023 - Segunda Quincena
            ['gestion' => 2023, 'mes' => 12, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.92], // PLOMO
            ['gestion' => 2023, 'mes' => 12, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.11], // ZINC
            ['gestion' => 2023, 'mes' => 12, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 23.92], // PLATA
            ['gestion' => 2023, 'mes' => 12, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.78], // COBRE
            // Enero 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.93], // PLOMO
            ['gestion' => 2024, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.17], // ZINC
            ['gestion' => 2024, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 24.07], // PLATA
            ['gestion' => 2024, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.84], // COBRE

            // Enero 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.93],
            ['gestion' => 2024, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.14],
            ['gestion' => 2024, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 23.14],
            ['gestion' => 2024, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.78],

            // Febrero 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.96],
            ['gestion' => 2024, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.14],
            ['gestion' => 2024, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 22.79],
            ['gestion' => 2024, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.79],

            // Febrero 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.95],
            ['gestion' => 2024, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.07],
            ['gestion' => 2024, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 22.59],
            ['gestion' => 2024, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.73],

            // Marzo 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 3, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.94],
            ['gestion' => 2024, 'mes' => 3, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.07],
            ['gestion' => 2024, 'mes' => 3, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 22.79],
            ['gestion' => 2024, 'mes' => 3, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.81],

            // Marzo 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.95],
            ['gestion' => 2024, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.12],
            ['gestion' => 2024, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 24.13],
            ['gestion' => 2024, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 3.89],
            // Abril 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.91], // PLOMO
            ['gestion' => 2024, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.11], // ZINC
            ['gestion' => 2024, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 24.84], // PLATA
            ['gestion' => 2024, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 3.99], // COBRE

            // Abril 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.95],
            ['gestion' => 2024, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.20],
            ['gestion' => 2024, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 27.50],
            ['gestion' => 2024, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.19],

            // Mayo 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.98],
            ['gestion' => 2024, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.28],
            ['gestion' => 2024, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 27.66],
            ['gestion' => 2024, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.40],

            // Mayo 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.99],
            ['gestion' => 2024, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.31],
            ['gestion' => 2024, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 27.53],
            ['gestion' => 2024, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.48],
            // Junio 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 1.02], // PLOMO
            ['gestion' => 2024, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.37], // ZINC
            ['gestion' => 2024, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 31.10], // PLATA
            ['gestion' => 2024, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.70], // COBRE

            // Junio 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.98],
            ['gestion' => 2024, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.27],
            ['gestion' => 2024, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 29.70],
            ['gestion' => 2024, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.43],

            // Julio 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.97],
            ['gestion' => 2024, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.28],
            ['gestion' => 2024, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 29.47],
            ['gestion' => 2024, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.31],

            // Julio 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.99],
            ['gestion' => 2024, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.32],
            ['gestion' => 2024, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 30.46],
            ['gestion' => 2024, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.39],

            // Agosto 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 8, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.94],
            ['gestion' => 2024, 'mes' => 8, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.21],
            ['gestion' => 2024, 'mes' => 8, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 29.09],
            ['gestion' => 2024, 'mes' => 8, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.14],

            // Agosto 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 8, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.89],
            ['gestion' => 2024, 'mes' => 8, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.19],
            ['gestion' => 2024, 'mes' => 8, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 27.76],
            ['gestion' => 2024, 'mes' => 8, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.00],

            // Septiembre 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 9, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.92],
            ['gestion' => 2024, 'mes' => 9, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.27],
            ['gestion' => 2024, 'mes' => 9, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 29.36],
            ['gestion' => 2024, 'mes' => 9, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.14],

            // Septiembre 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 9, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.89],
            ['gestion' => 2024, 'mes' => 9, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.24],
            ['gestion' => 2024, 'mes' => 9, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 28.67],
            ['gestion' => 2024, 'mes' => 9, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.07],
            // Octubre 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 10, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.92], // PLOMO
            ['gestion' => 2024, 'mes' => 10, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.33], // ZINC
            ['gestion' => 2024, 'mes' => 10, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 31.23], // PLATA
            ['gestion' => 2024, 'mes' => 10, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.31], // COBRE

            // Octubre 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 10, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.93],
            ['gestion' => 2024, 'mes' => 10, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.40],
            ['gestion' => 2024, 'mes' => 10, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 31.31],
            ['gestion' => 2024, 'mes' => 10, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.38],

            // Noviembre 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 11, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.91],
            ['gestion' => 2024, 'mes' => 11, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.41],
            ['gestion' => 2024, 'mes' => 11, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 33.43],
            ['gestion' => 2024, 'mes' => 11, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.28],

            // Noviembre 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 11, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.90],
            ['gestion' => 2024, 'mes' => 11, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.35],
            ['gestion' => 2024, 'mes' => 11, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 31.46],
            ['gestion' => 2024, 'mes' => 11, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.19],

            // Diciembre 2024 - Primera Quincena
            ['gestion' => 2024, 'mes' => 12, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.90],
            ['gestion' => 2024, 'mes' => 12, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.37],
            ['gestion' => 2024, 'mes' => 12, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 30.78],
            ['gestion' => 2024, 'mes' => 12, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.04],

            // Diciembre 2024 - Segunda Quincena
            ['gestion' => 2024, 'mes' => 12, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.92],
            ['gestion' => 2024, 'mes' => 12, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.40],
            ['gestion' => 2024, 'mes' => 12, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 31.25],
            ['gestion' => 2024, 'mes' => 12, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.08],
            // Enero 2025 - Primera Quincena
            ['gestion' => 2025, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.88], // PLOMO
            ['gestion' => 2025, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.36], // ZINC
            ['gestion' => 2025, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 29.68], // PLATA
            ['gestion' => 2025, 'mes' => 1, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.01], // COBRE

            // Enero 2025 - Segunda Quincena
            ['gestion' => 2025, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.87],
            ['gestion' => 2025, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.29],
            ['gestion' => 2025, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 29.92],
            ['gestion' => 2025, 'mes' => 1, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.04],

            // Febrero 2025 - Primera Quincena
            ['gestion' => 2025, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.87],
            ['gestion' => 2025, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.27],
            ['gestion' => 2025, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 30.66],
            ['gestion' => 2025, 'mes' => 2, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.10],

            // Febrero 2025 - Segunda Quincena
            ['gestion' => 2025, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.88],
            ['gestion' => 2025, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.26],
            ['gestion' => 2025, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 32.06],
            ['gestion' => 2025, 'mes' => 2, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.19],

            // Marzo 2025 - Primera Quincena
            ['gestion' => 2025, 'mes' => 3, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.89],
            ['gestion' => 2025, 'mes' => 3, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.28],
            ['gestion' => 2025, 'mes' => 3, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 29.41],
            ['gestion' => 2025, 'mes' => 3, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.28],

            // Marzo 2025 - Segunda Quincena
            ['gestion' => 2025, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.92],
            ['gestion' => 2025, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.30],
            ['gestion' => 2025, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 32.58],
            ['gestion' => 2025, 'mes' => 3, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.35],

            // Abril 2025 - Primera Quincena
            ['gestion' => 2025, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.93],
            ['gestion' => 2025, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.32],
            ['gestion' => 2025, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 33.74],
            ['gestion' => 2025, 'mes' => 4, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.47],

            // Abril 2025 - Segunda Quincena
            ['gestion' => 2025, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.86],
            ['gestion' => 2025, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.20],
            ['gestion' => 2025, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 31.75],
            ['gestion' => 2025, 'mes' => 4, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.13],

            // Mayo 2025 - Primera Quincena
            ['gestion' => 2025, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.87],
            ['gestion' => 2025, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.17],
            ['gestion' => 2025, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 32.89],
            ['gestion' => 2025, 'mes' => 5, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.22],

            // Mayo 2025 - Segunda Quincena
            ['gestion' => 2025, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.89],
            ['gestion' => 2025, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.19],
            ['gestion' => 2025, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 32.53],
            ['gestion' => 2025, 'mes' => 5, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.30],

            // Junio 2025 - Primera Quincena
            ['gestion' => 2025, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.89],
            ['gestion' => 2025, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.21],
            ['gestion' => 2025, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 32.88],
            ['gestion' => 2025, 'mes' => 6, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.35],

            // Junio 2025 - Segunda Quincena
            ['gestion' => 2025, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.89],
            ['gestion' => 2025, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.19],
            ['gestion' => 2025, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 35.53],
            ['gestion' => 2025, 'mes' => 6, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.42],

            // Julio 2025 - Primera Quincena
            ['gestion' => 2025, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 1, 'valor' => 0.90],
            ['gestion' => 2025, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 2, 'valor' => 1.21],
            ['gestion' => 2025, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 3, 'valor' => 36.32],
            ['gestion' => 2025, 'mes' => 7, 'quincena' => 'PRIMERA', 'mineral_id' => 4, 'valor' => 4.50],

            // Julio 2025 - Segunda Quincena
            ['gestion' => 2025, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 1, 'valor' => 0.91],
            ['gestion' => 2025, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 2, 'valor' => 1.23],
            ['gestion' => 2025, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 3, 'valor' => 37.07],
            ['gestion' => 2025, 'mes' => 7, 'quincena' => 'SEGUNDA', 'mineral_id' => 4, 'valor' => 4.46],

        ];

        foreach ($datos as $item) {
            Cotizacion::updateOrCreate(
                [
                    'mineral_id' => $item['mineral_id'],
                    'quincena'   => $item['quincena'],
                    'mes'        => $item['mes'],
                    'gestion'    => $item['gestion'],
                ],
                ['valor' => $item['valor']]
            );
        }
    }
}
