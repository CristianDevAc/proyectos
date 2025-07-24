<?php

namespace App\Http\Controllers;

use App\Models\Liquidacion;
use App\Models\Mineral;
use App\Models\Contribucion;
use Illuminate\Http\Request;
use App\Models\Cooperativa;
use Carbon\Carbon;

class ReportesController extends Controller
{
    // Mostrar vista inicial de reportes (filtros)
    public function index()
    {
        $cooperativas = Cooperativa::orderBy('nombre')->get();
        return view('reportes.index', compact('cooperativas'));
    }
    public function filtrar(Request $request)
    {
        $request->validate([
            'cooperativa_id' => 'required|exists:cooperativas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $liquidaciones = Liquidacion::whereHas('carga', function($q) use ($request) {
                $q->where('cooperativa_id', $request->cooperativa_id);
            })
            ->whereBetween('fecha_liquidacion', [$request->fecha_inicio, $request->fecha_fin])
            ->with(['carga.personas', 'minerales', 'contribuciones'])
            ->get();

        $minerales = Mineral::all();
        $contribuciones = Contribucion::all(); // <--- AÑADIR ESTA LÍNEA

        return view('reportes.resultado', compact('liquidaciones', 'minerales', 'contribuciones'));
    }


    // Filtrar liquidaciones según cooperativa y fechas
    public function reporteLiquidaciones(Request $request)
    {
        $request->validate([
            'cooperativa_id' => 'required|exists:cooperativas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $minerales = \App\Models\Mineral::all();
        $liquidaciones = \App\Models\Liquidacion::whereHas('carga', function($q) use ($request) {
                $q->where('cooperativa_id', $request->cooperativa_id);
            })
            ->whereBetween('fecha_liquidacion', [$request->fecha_inicio, $request->fecha_fin])
            ->with(['carga.cooperativa', 'carga.personas', 'minerales', 'contribuciones'])
            ->get();

        foreach ($liquidaciones as $liq) {
            $liq->pesosFinosCalculados = $this->calcularPesosFinosPorLiquidacion($liq);
        }

        return view('reportes.reporte_liquidaciones', compact('liquidaciones', 'minerales'));
    }

    // Función utilitaria (por ejemplo, pesos finos)
    public function calcularPesosFinosPorLiquidacion(Liquidacion $liquidacion)
    {
        $pesoHumedo = $liquidacion->peso_humedo;
        $minerales = $liquidacion->minerales;

        $pesosFinos = [];

        foreach ($minerales as $mineral) {
            $ley = $mineral->pivot->ley ?? 0;
            $conversion = $mineral->conversion;
            $divisor = ($conversion == 32.1507) ? 1000 : 100;

            $pesoFino = $pesoHumedo * ($ley / $divisor);

            $pesosFinos[] = [
                'mineral' => $mineral->nombre,
                'ley' => $ley,
                'conversion' => $conversion,
                'peso_fino' => round($pesoFino, 3),
            ];
        }

        return $pesosFinos;
    }
    public function m02(Request $request)
    {
        // Validación y obtención de variables (igual que antes)
        $request->validate([
            'cooperativa_id' => 'required|exists:cooperativas,id',
            'quincena' => 'required|in:1,2',
            'mes' => 'required|integer|min:1|max:12',
            'gestion' => 'required|integer|min:2000|max:2100',
        ]);

        $cooperativa = Cooperativa::findOrFail($request->cooperativa_id);

        $gestion = $request->gestion;
        $mes = $request->mes;
        $quincena = $request->quincena;
        $totalPesoHumedo = 0;
        $totalPesoSeco = 0;
        $totalImporte = 0;
        $totalRegalias = 0;
        $totalDeducciones = 0;
        $totalLiquidoPagable = 0;

        $nombreCooperativa = $cooperativa->nombre;

        $fechaInicio = Carbon::create($gestion, $mes, $quincena == 1 ? 1 : 16);
        $fechaFin = Carbon::create($gestion, $mes, $quincena == 1 ? 15 : $fechaInicio->copy()->endOfMonth()->day);

        $liquidaciones = Liquidacion::whereHas('carga', function ($query) use ($request) {
                $query->where('cooperativa_id', $request->cooperativa_id);
            })
            ->whereBetween('fecha_liquidacion', [$fechaInicio, $fechaFin])
            ->with(['carga.personas', 'minerales', 'contribuciones'])
            ->get();

        $minerales = Mineral::all();
        $contribuciones = Contribucion::all();

        $contribucionesPorTipo = [];

        foreach ($contribuciones as $contribucion) {
            $contribucionesPorTipo[$contribucion->tipo] = 0;
        }

        foreach ($liquidaciones as $liquidacion) {
            foreach ($liquidacion->contribuciones as $contribucion) {
                $tipo = $contribucion->tipo;
                $contribucionesPorTipo[$tipo] += $contribucion->monto;
            }
        }
        $pesosFinosTotales = [];
        foreach ($minerales as $mineral) {
            $pesosFinosTotales[$mineral->nombre] = 0;
        }

        // Inicializar montos por contribución
        $contribucionesTotales = [];
        foreach ($contribuciones as $contribucion) {
            $contribucionesTotales[$contribucion->id] = 0;
        }

        foreach ($liquidaciones as $liquidacion) {
            $totalPesoHumedo += $liquidacion->peso_humedo;
            $totalPesoSeco += $liquidacion->peso_seco;
            $totalImporte += $liquidacion->importe_total;
            $totalRegalias += $liquidacion->total_regalia;
            $totalDeducciones += $liquidacion->total_deducciones;
            $totalLiquidoPagable += $liquidacion->liquido_pagable;

            $pesosFinos = app(\App\Http\Controllers\ReportesController::class)
                ->calcularPesosFinosPorLiquidacion($liquidacion);

            foreach ($pesosFinos as $item) {
                $pesosFinosTotales[$item['mineral']] += $item['peso_fino'];
            }

            foreach ($liquidacion->contribuciones as $contribucion) {
                $porcentaje = $contribucion->pivot->porcentaje ?? 0;
                $monto = ($porcentaje * $liquidacion->importe_total) / 100;
                $contribucionesTotales[$contribucion->id] += $monto;
            }
        }
        // Llamamos a las funciones para los literales
        $mesLiteral = $this->nombreMes($mes);
        $quincenaLiteral = $this->nombreQuincena($quincena);

        return view('reportes.m02', compact(
            'cooperativa',
            'liquidaciones',
            'contribucionesPorTipo',
            'minerales',
            'contribuciones',
            'fechaInicio',
            'fechaFin',
            'gestion',
            'mesLiteral',
            'quincenaLiteral',
            'nombreCooperativa',
            'totalPesoHumedo',
            'totalPesoSeco',
            'totalImporte',
            'totalRegalias',
            'totalDeducciones',
            'totalLiquidoPagable',
            'pesosFinosTotales',
            'contribucionesTotales'
        ));
    }
    public function nombreMes(int $mes): string
    {
        // Usamos Carbon para obtener el nombre del mes en español
        return \Carbon\Carbon::create()->month($mes)->locale('es')->isoFormat('MMMM');
    }

    public function nombreQuincena(int $quincena): string
    {
        return $quincena === 1 ? 'Primera (1 al 15)' : 'Segunda (16 al fin de mes)';
    }
}
