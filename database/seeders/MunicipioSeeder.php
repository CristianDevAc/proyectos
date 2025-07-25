<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $municipios = [
            "ACASIO", "ARAMPAMPA", "CARIPUYO", "CHAYANTA", "CHUQUIUTA", "COLQUECHACA", "LLALLAGUA", "OCURI", "POCUATA",
            "RAVELO", "SACACA", "SAN PEDRO DE BUENA VISTA", "SAN PEDRO DE MACHA", "TORO TORO", "UNCIA", "BELEN DE URMIRI",
            "BETANZOS", "CAIZA D", "CHAQUI", "CKOCHAS", "POTOSI", "PUNA", "TACOBAMBA", "TINGUIPAYA", "YOCALLA", "ATOCHA",
            "COTAGAITA", "TUPIZA", "VILLAZON", "VITICHI", "COLCHA K", "LLICA", "MOJINETE", "PORCO", "SAN AGUSTIN",
            "SAN ANTONIO DE ESMORUCO", "SAN PABLO DE LIPEZ", "MUNICIPIO DE SAN PEDRO DE QUEMES", "TAHUA", "TOMAVE", "UYUNI"
        ];

        foreach ($municipios as $nombre) {
           DB::table('municipios')->updateOrInsert([
             'nombre' => $nombre,
             'created_at' => now(),
             'updated_at' => now(),
           ]);
        }
    }
}
