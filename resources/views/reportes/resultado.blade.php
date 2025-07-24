@extends('adminlte::page')

@section('title', 'Reporte de Liquidaciones')

@section('content_header')
    <h1>Resultado de Reporte</h1>
@stop

@section('css')
<style>
    .btn-volver {
        margin-bottom: 1rem;
        font-size: 0.85rem;
        padding: 0.4rem 1rem;
        border-radius: 0.25rem;
    }
    .btn-volver:hover {
        background-color: #004085;
    }

    .table {
        font-size: 0.75rem;
    }
    .table thead th {
        font-weight: 600;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table tbody td {
        vertical-align: middle;
        white-space: nowrap;
        padding: 0.3rem 0.4rem;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive">

            <a href="{{ route('reportes.index') }}" class="btn btn-primary btn-volver">
                <i class="fas fa-arrow-left"></i> Volver
            </a>

            <table class="table table-bordered table-striped table-sm text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Proveedor</th>
                        <th>Nro. Lote</th>
                        <th>Fecha</th>

                        @foreach($minerales as $mineral)
                            <th>Ley {{ $mineral->nombre }}</th>
                        @endforeach

                        <th>P. Húmedo</th>
                        <th>P. Seco</th>

                        @foreach($minerales as $mineral)
                            <th>P. Fino {{ $mineral->nombre }}</th>
                        @endforeach

                        @foreach($contribuciones as $contribucion)
                            <th>{{ $contribucion->nombre }}</th>
                        @endforeach

                        <th>Importe Total</th>
                        <th>Regalías</th>
                        <th>Total Deducciones</th>
                        <th>Liquido Pagable</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($liquidaciones as $liquidacion)
                        @php
                            $pesosFinos = app(\App\Http\Controllers\ReportesController::class)
                                ->calcularPesosFinosPorLiquidacion($liquidacion);
                            $pesosFinosArray = collect($pesosFinos)->keyBy('mineral');
                            $contribucionesArray = collect($liquidacion->contribuciones)
                                ->keyBy('id');
                        @endphp
                        <tr>
                            <td>{{ optional($liquidacion->carga->personas->firstWhere('pivot.tipo', 'PROVEEDOR'))->nombre_completo ?? 'N/A' }}</td>
                            <td>{{ $liquidacion->carga->lote ?? 'N/A' }}</td>
                            <td>{{ $liquidacion->fecha_liquidacion->format('d/m/Y') }}</td>

                            @foreach($minerales as $mineral)
                                @php
                                    $ley = optional($liquidacion->minerales->firstWhere('id', $mineral->id))->pivot->ley ?? 0;
                                @endphp
                                <td>{{ number_format($ley, 2) }}</td>
                            @endforeach

                            <td>{{ number_format($liquidacion->peso_humedo, 2) }}</td>
                            <td>{{ number_format($liquidacion->peso_seco, 2) }}</td>

                            @foreach($minerales as $mineral)
                                @php
                                    $pesoFino = $pesosFinosArray[$mineral->nombre]['peso_fino'] ?? 0;
                                @endphp
                                <td>{{ number_format($pesoFino, 3) }}</td>
                            @endforeach

                            @foreach($contribuciones as $contribucion)
                                @php
                                    $porcentaje = $contribucionesArray[$contribucion->id]->pivot->porcentaje ?? 0;
                                    $monto = ($porcentaje * $liquidacion->importe_total) / 100;
                                @endphp
                                <td>Bs {{ number_format($monto, 2) }}</td>
                            @endforeach

                            <td>Bs {{ number_format($liquidacion->importe_total, 2) }}</td>
                            <td>Bs {{ number_format($liquidacion->total_regalia, 2) }}</td>
                            <td>Bs {{ number_format($liquidacion->total_deducciones, 2) }}</td>
                            <td><strong>Bs {{ number_format($liquidacion->liquido_pagable, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop