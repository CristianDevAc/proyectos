<?php

namespace App\Http\Controllers;

use App\Models\MuestraLaboratorio;
use App\Models\Carga;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MuestraLaboratorioController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->input('buscar');

        $query = MuestraLaboratorio::with(['carga.personas', 'laboratorio']);

        if ($busqueda) {
            $query->whereHas('carga', function ($q) use ($busqueda) {
                $q->where('lote', 'like', "%{$busqueda}%")
                ->orWhereHas('personas', function ($subq) use ($busqueda) {
                    $subq->where('nombre_completo', 'like', "%{$busqueda}%");
                });
            });
        }

        $porPagina = $request->input('por_pagina', 10);

        $muestras = $query->orderBy('id', 'desc')->paginate($porPagina);

        return view('muestras.index', compact('muestras', 'busqueda', 'porPagina'));
    }

    public function create()
    {
        
        $laboratorios = Laboratorio::all();
        $cargas = Carga::with(['personas' => function ($q) {
            $q->wherePivot('tipo', 'PROVEEDOR');
        }])->where('estado', 'PESAJE')->get();
        return view('muestras.create', compact('laboratorios', 'cargas'));
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'carga_id' => 'required|exists:cargas,id',
            'laboratorio_id' => 'required|exists:laboratorios,id',
            'fecha_muestra' => 'required|date',
            'tipo' => 'required|in:NORMAL,CERTIFICADO',
            'observaciones' => 'nullable|string',
            'minerales' => 'required|array|min:1',
            'minerales.*.mineral_id' => 'required|exists:minerales,id',
            'minerales.*.ley' => 'required|numeric|min:0|max:100',
            'minerales.*.humedad' => 'required|numeric|min:0|max:100',
            'imagen_certificado' => 'nullable|image|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $muestraData = [
                'carga_id' => $request->carga_id,
                'laboratorio_id' => $request->laboratorio_id,
                'fecha_muestra' => $request->fecha_muestra,
                'tipo' => $request->tipo,
                'estado' => 0,
                'observaciones' => $request->observaciones,
            ];

            if ($request->hasFile('imagen_certificado')) {
                $image = $request->file('imagen_certificado');

                // Guarda en storage/app/public/certificados
                $ruta = $image->store('certificados', 'public');

                // Guarda solo la ruta relativa (por ejemplo: certificados/imagen123.png)
                $muestraData['imagen_certificado'] = $ruta;
            }

            $muestra = MuestraLaboratorio::create($muestraData);

            foreach ($request->minerales as $detalle) {
                $muestra->detalles()->create([
                    'mineral_id' => $detalle['mineral_id'],
                    'ley' => $detalle['ley'],
                    'humedad' => $detalle['humedad'],
                ]);
            }

            DB::commit();

            return redirect()->route('muestras.index')
                ->with('success', 'Muestra de laboratorio registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            dd('ERROR DETECTADO', $e->getMessage(), $e);
        }
    }
    public function show(MuestraLaboratorio $muestra)
    {
        return view('muestras.show', compact('muestra'));
    }
}