<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mineral;
use Carbon\Carbon;
use App\Models\Cotizacion;

class DashboardController extends Controller
{
    public function minerales(Request $request)
    {
        $filtro = $request->input('filtro', 'ANIO');

        $minerales = Mineral::orderBy('nombre')->get();

        $datos = [];

        foreach ($minerales as $mineral) {
            $cotizaciones = Cotizacion::where('mineral_id', $mineral->id)
                ->orderBy('gestion')
                ->orderBy('mes')
                ->orderBy('quincena')
                ->get(['gestion', 'mes', 'quincena', 'valor']);

            $datos[$mineral->nombre] = $cotizaciones;
        }

        // Obtener fecha actual para verificar cotizaciones actuales
        $now = Carbon::now();
        $gestion = $now->year;
        $mes = $now->month;
        $quincena = $now->day <= 15 ? 'PRIMERA' : 'SEGUNDA';

        $cotizacionesActuales = Cotizacion::with('mineral')
            ->where('gestion', $gestion)
            ->where('mes', $mes)
            ->where('quincena', $quincena)
            ->get();

        $hayCotizaciones = $cotizacionesActuales->isNotEmpty();

        return view('home', compact(
            'datos', 'minerales', 'filtro',
            'cotizacionesActuales', 'hayCotizaciones',
            'quincena', 'mes', 'gestion'
        ));
    }
    
}
