<?php

namespace App\Http\Controllers;

use App\Models\Liquidacion;
use App\Models\Cooperativa;
use App\Models\ConcesionMina;
use App\Models\Municipio;
use App\Models\Contribucion;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Carga;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


class LiquidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Liquidacion::with('carga');

        // Búsqueda por lote de carga o fecha de liquidación (busqueda puede ser lote o fecha dd/mm/yyyy)
        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;

            $query->where(function($q) use ($busqueda) {
                // Buscar por lote (relación carga)
                $q->whereHas('carga', function($q2) use ($busqueda) {
                    $q2->where('lote', 'like', "%{$busqueda}%");
                });

                // Buscar por fecha de liquidación en formato d/m/Y o Y-m-d
                $fecha = \DateTime::createFromFormat('d/m/Y', $busqueda) ?: \DateTime::createFromFormat('Y-m-d', $busqueda);
                if ($fecha) {
                    $q->orWhereDate('fecha_liquidacion', $fecha->format('Y-m-d'));
                }
            });
        }

        // Cantidad de resultados por página
        $perPage = $request->get('per_page', 10);

        // Ordenar por fecha_liquidacion descendente
        $liquidaciones = $query->orderBy('fecha_liquidacion', 'desc')->paginate($perPage);

        return view('liquidacion.index', compact('liquidaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cargas = Carga::with(['personas', 'muestrasLaboratorio', 'minerales'])
                    ->where('estado', 'PESAJE')
                    ->get();

        $cooperativas = Cooperativa::all();
        $concesiones = ConcesionMina::all();
        $municipios = Municipio::all();

        // Contribuciones iniciales (para precargar en la tabla)
        $contribucionesIniciales = Contribucion::where('inicial', 1)->get();

        // Todas las contribuciones (para el modal)
        $todasLasContribuciones = Contribucion::all();

        return view('liquidacion.create', compact(
            'cargas',
            'cooperativas',
            'concesiones',
            'municipios',
            'contribucionesIniciales',
            'todasLasContribuciones'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'cotizacion_dolar' => 6.96
        ]);
        $request->validate([
            'carga_id' => 'required|exists:cargas,id',
            'fecha_liquidacion' => 'required|date',
            'peso_humedo' => 'required|numeric|min:0',
            'humedad' => 'required|numeric|min:0|max:100',
            'peso_seco' => 'required|numeric|min:0',
            'valor_tonelada_bs' => 'required|numeric|min:0',
            'importe_total' => 'required|numeric|min:0',
            'valor_bruto_compra' => 'required|numeric|min:0',
            'total_deducciones' => 'required|numeric|min:0',
            'cotizacion_dolar' => 'required|numeric|min:0',
            'liquido_pagable' => 'required|numeric|min:0',
            'regalia_minera' => 'required|numeric|min:0',
            'muestra' => 'nullable|exists:muestra_laboratorio,id',

            'contribuciones' => 'nullable|array',
            'contribuciones.*.id' => 'required|exists:contribuciones,id',
            'contribuciones.*.precio' => 'required|numeric|min:0',
            'tipo_regalia' => 'required|in:oficial,porcentaje',
            'porcentaje_regalia' => 'nullable|numeric|min:0|max:100',
        ]);
        $totalRegalia = 0;

        if ($request->tipo_regalia === 'oficial') {
            // Calcular en backend la suma de VBVmineral * alicuota o usar valor enviado desde frontend
            $totalRegalia = $request->regalia_minera; // o calcular aquí
        } else {
            // Calcula por porcentaje del importe total
            $totalRegalia = ($request->importe_total * $request->porcentaje_regalia) / 100;
        }
        DB::beginTransaction();

        try {
            Log::info('➡️ Entrando al bloque TRY antes de crear liquidación.');

            $liquidacion = Liquidacion::create([
                'carga_id' => $request->carga_id,
                'fecha_liquidacion' => $request->fecha_liquidacion,
                'peso_humedo' => $request->peso_humedo,
                'humedad' => $request->humedad,
                'peso_seco' => $request->peso_seco,
                'valor_tonelada_bs' => $request->valor_tonelada_bs,
                'importe_total' => $request->importe_total,
                'valor_bruto_compra' => $request->valor_bruto_compra,
                'total_deducciones' => $request->total_deducciones,
                'cotizacion_dolar' => $request->cotizacion_dolar,
                'liquido_pagable' => $request->liquido_pagable,
                'total_regalia' =>  $totalRegalia,
                'muestra' => $request->muestra ?? 0,
            ]);
            $carga = $liquidacion->carga;
            $carga->estado = 'LIQUIDACION';
            $carga->save();
            foreach ($request->contribuciones ?? [] as $contribucion) {
                $liquidacion->contribuciones()->attach($contribucion['id'], [
                    'porcentaje' => $contribucion['porcentaje'] ?? 0,
                    'precio' => $contribucion['precio'],
                ]);
            }
            foreach ($request->minerales ?? [] as $mineralId => $ley) {
                $liquidacion->minerales()->attach($mineralId, [
                    'ley' => $ley ?? 0
                ]);
            }

            DB::commit();

            return redirect()->route('liquidaciones.index')->with('success', 'Liquidación guardada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error en liquidación: ' . $e->getMessage());
            throw $e;
        }

    }
    
    public function show(Liquidacion $liquidacion)
    {
        $carga = $liquidacion->carga;
        $minerales = $carga->minerales; // relacionados con la carga

        $fecha = $liquidacion->fecha_liquidacion;

        // Calculamos quincena, mes y gestión con Carbon
        $mes = $fecha->format('m');
        $gestion = $fecha->format('Y');
        $quincena = $fecha->day <= 15 ? 'Primera' : 'Segunda';

        $cotizaciones = [];

        foreach ($minerales as $mineral) {
            $cotizacion = Cotizacion::where('mineral_id', $mineral->id)
                ->where('mes', $mes)
                ->where('gestion', $gestion)
                ->where('quincena', $quincena)
                ->first();

            $cotizaciones[] = [
                'mineral' => $mineral,
                'cotizacion' => $cotizacion?->valor ?? 'No registrada',
                'alicuota' => $mineral->pivot->alicuota ?? 0,
            ];
        }

        return view('liquidacion.show', compact('liquidacion', 'cotizaciones'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    

    public function pdf(Liquidacion $liquidacion)
    {
        $carga = $liquidacion->carga;
        $minerales = $carga->minerales;

        $fecha = $liquidacion->fecha_liquidacion;
        $mes = $fecha->format('m');
        $gestion = $fecha->format('Y');
        $quincena = $fecha->day <= 15 ? 'Primera' : 'Segunda';

        $cotizaciones = [];

        foreach ($minerales as $mineral) {
            $cotizacion = \App\Models\Cotizacion::where('mineral_id', $mineral->id)
                ->where('mes', $mes)
                ->where('gestion', $gestion)
                ->where('quincena', $quincena)
                ->first();

            $cotizaciones[] = [
                'mineral' => $mineral,
                'cotizacion' => $cotizacion?->valor ?? 'No registrada',
                'alicuota' => $mineral->pivot->alicuota ?? 0,
            ];
        }

        $pdf = Pdf::loadView('liquidacion.pdf', compact('liquidacion', 'cotizaciones'))
                ->setPaper('letter', 'portrait');

        return $pdf->stream("liquidacion_{$liquidacion->id}.pdf");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
