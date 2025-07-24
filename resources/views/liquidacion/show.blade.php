@extends('adminlte::page')

@section('title', 'Detalle de Liquidación')

@section('content_header')
    <h1>Detalle de Liquidación</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body p-4">

        <table class="table table-bordered w-100 text-sm text-center">
            <!-- Cabecera principal -->
            <tr class="bg-light">
                <td colspan="9" class="text-center">
                    <h4 class="mb-0 font-weight-bold text-uppercase">LIQUIDACIÓN DE MINERALES</h4>
                    <small class="text-muted">EXPRESADO EN BOLIVIANOS</small>
                </td>
            </tr>

            <!-- Fila 1 -->
            <tr>
                <th class="bg-secondary text-white">NOMBRE DEL PROVEEDOR</th>
                <td>{{ optional($liquidacion->carga->personas->firstWhere('pivot.tipo', 'PROVEEDOR'))->nombre_completo ?? 'N/A' }}</td>
                <th class="bg-secondary text-white">MINA Y/O CONCESIÓN</th>
                <td>{{ $liquidacion->carga->concesionMina->mina ?? 'N/A' }}</td>
                <th class="bg-secondary text-white">FECHA ENTREGA</th>
                <td>{{ $liquidacion->carga->fecha_registro->format('d/m/Y') ?? 'N/A' }}</td>
                <th class="bg-secondary text-white">COOPERATIVA MINERA</th>
                <td colspan="2">{{ $liquidacion->carga->cooperativa->nombre ?? 'N/A' }}</td>
            </tr>

            <!-- Fila 2 -->
            <tr>
                <th class="bg-secondary text-white">T/C USC</th>
                <td>{{ number_format($liquidacion->cotizacion_dolar, 2) }}</td>
                <th class="bg-secondary text-white">COTIZACIÓN OFICIAL</th>
                <td colspan="6" class="text-left">
                    <div class="row">
                        @forelse($liquidacion->carga->minerales as $mineral)
                            @php
                                $cotizacion = \App\Models\Cotizacion::where('mineral_id', $mineral->id)
                                    ->where('gestion', $liquidacion->fecha_liquidacion->format('Y'))
                                    ->where('mes', $liquidacion->fecha_liquidacion->format('m'))
                                    ->orderByDesc('quincena')
                                    ->first();
                            @endphp
                            <div class="col-md-6">
                                <strong>{{ $mineral->nombre }}</strong>
                                (Alicuota: {{ $mineral->alicuota ?? 0 }}%) - 
                                Cotización: Bs {{ number_format($cotizacion->valor ?? 0, 2) }}
                            </div>
                        @empty
                            <div class="col-12 text-muted">No hay minerales registrados.</div>
                        @endforelse
                    </div>
                </td>
            </tr>

            <!-- Fila 3: Datos clave -->
            <tr class="bg-light">
                <th>NRO LOTE</th>
                <th>P.N.H</th>
                <th>P.N.S</th>
                <th colspan="3">LEYES</th>
                <th>V. BRUTO COMPRA</th>
                <th>PRECIO/KILO</th>
                <th>IMPORTE</th>
            </tr>
            <tr>
                <td>{{ $liquidacion->carga->lote ?? 'N/A' }}</td>
                <td>{{ number_format($liquidacion->peso_humedo, 2) }} kg</td>
                <td>{{ number_format($liquidacion->peso_seco, 2) }} kg</td>
                <td colspan="3" class="text-left">
                    @forelse($liquidacion->minerales as $mineral)
                        {{ $mineral->nombre }}: {{ number_format($mineral->pivot->ley, 2) }}% <br>
                    @empty
                        <span class="text-muted">No registradas</span>
                    @endforelse
                </td>
                <td>Bs {{ number_format($liquidacion->valor_bruto_compra, 2) }}</td>
                <td>Bs {{ number_format($liquidacion->valor_tonelada_bs, 2) }}</td>
                <td>Bs {{ number_format($liquidacion->importe_total, 2) }}</td>
            </tr>

            <!-- Fila 4: Contribuciones -->
            <tr class="bg-light">
                <th colspan="5">CONTRIBUCIONES</th>
                <th>TOTAL DEDUCCIONES</th>
                <th>TOTAL REGALÍA</th>
                <th colspan="2">LÍQUIDO PAGABLE</th>
            </tr>
            <tr>
                <td colspan="5" class="text-left">
                    <ul class="list-unstyled mb-0">
                        @foreach($liquidacion->contribuciones as $contribucion)
                            @php
                                $porcentaje = $contribucion->pivot->porcentaje ?? 0;
                                $monto = ($porcentaje * $liquidacion->importe_total) / 100;
                            @endphp
                            <li>{{ $contribucion->nombre }} ({{ $porcentaje }}%) - Bs {{ number_format($monto, 2) }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>Bs {{ number_format($liquidacion->total_deducciones, 2) }}</td>
                <td>Bs {{ number_format($liquidacion->total_regalia, 2) }}</td>
                <td colspan="2"><strong>Bs {{ number_format($liquidacion->liquido_pagable, 2) }}</strong></td>
            </tr>
        </table>
        <div class="mt-4">
            <a href="{{ route('liquidaciones.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Volver a Liquidaciones
            </a>
        </div>
        <a href="{{ route('liquidaciones.pdf', $liquidacion->id) }}" class="btn btn-danger mb-3" target="_blank">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
    </div>
</div>
@stop