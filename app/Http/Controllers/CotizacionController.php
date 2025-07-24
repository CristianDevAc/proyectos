<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Mineral;
use App\Models\Carga;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Cotizacion::with('mineral')
                    ->orderByDesc('gestion')
                    ->orderByDesc('mes')
                    ->orderBy('quincena');

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->whereHas('mineral', function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%$busqueda%");
            })->orWhere('gestion', 'like', "%$busqueda%");
        }

        $cotizaciones = $query->paginate($request->get('per_page', 10));

        return view('cotizacion.index', compact('cotizaciones'));
    }

    public function create()
    {
        $minerales = Mineral::orderBy('nombre')->get();
        return view('cotizacion.create', compact('minerales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mineral_id' => 'required|exists:minerales,id',
            'quincena'   => 'required|in:PRIMERA,SEGUNDA',
            'mes'        => 'required|integer|min:1|max:12',
            'gestion'    => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'valor'      => 'required|numeric|min:0',
        ]);

        Cotizacion::create($request->all());

        return redirect()->route('cotizacion.index')->with('success', 'Cotización registrada correctamente.');
    }

    public function edit(Cotizacion $cotizacion)
    {
        $minerales = Mineral::orderBy('nombre')->get();
        return view('cotizaciones.edit', compact('cotizacion', 'minerales'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        $request->validate([
            'mineral_id' => 'required|exists:minerales,id',
            'quincena'   => 'required|in:PRIMERA,SEGUNDA',
            'mes'        => 'required|integer|min:1|max:12',
            'gestion'    => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'valor'      => 'required|numeric|min:0',
        ]);

        $cotizacion->update($request->all());

        return redirect()->route('cotizacion.index')->with('success', 'Cotización actualizada correctamente.');
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();
        return redirect()->route('cotizacion.index')->with('success', 'Cotización eliminada correctamente.');
    }

    
}