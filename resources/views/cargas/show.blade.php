@extends('adminlte::page')

@section('title', 'Detalle de Carga')

@section('content_header')
    <h1>Detalle de la Carga</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Datos Registrados</h3>
    </div>

    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <th>Plataforma</th>
                <td>{{ $carga->plataforma->nombre ?? '-' }}</td>
            </tr>
            <tr>
                <th>Cooperativa</th>
                <td>{{ $carga->cooperativa->nombre ?? '-' }}</td>
            </tr>
            <tr>
                <th>Concesión Mina</th>
                <td>{{ $carga->concesionMina->mina ?? '-' }}</td>
            </tr>
            <tr>
                <th>Camión</th>
                <td>{{ $carga->camion->placa ?? '-' }}</td>
            </tr>
            <tr>
                <th>Lote</th>
                <td>{{ $carga->lote }}</td>
            </tr>
            <tr>
                <th>Producto</th>
                <td>{{ $carga->producto ?? '-' }}</td>
            </tr>
            <tr>
                <th>Peso Bruto</th>
                <td>{{ $carga->peso_bruto }} kg</td>
            </tr>
            <tr>
                <th>Peso Tara</th>
                <td>{{ $carga->peso_tara }} kg</td>
            </tr>
            <tr>
                <th>Peso Neto</th>
                <td>{{ $carga->peso_neto }} kg</td>
            </tr>
            <tr>
                <th>Cantidad de Sacos</th>
                <td>{{ $carga->cantidad_sacos ?: '-' }}</td>
            </tr>
            <tr>
                <th>Fecha Registro</th>
                <td>{{ $carga->fecha_registro?->format('d/m/Y') ?? '-' }}</td>
            </tr>
            <tr>
                <th>Número Boleta</th>
                <td>{{ $carga->numero_boleta }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>
                    <span class="badge badge-primary">{{ $carga->estado }}</span>
                </td>
            </tr>
            <tr>
                <th>Tipo</th>
                <td>
                    <span class="badge badge-success">{{ $carga->tipo }}</span>
                </td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td>{{ $carga->observaciones ?? 'Sin observaciones' }}</td>
            </tr>
            <tr>
                <th>Minerales</th>
                <td>
                    @forelse($carga->minerales as $mineral)
                        <span class="badge badge-warning">{{ $mineral->nombre }}</span>
                    @empty
                        <span class="text-muted">No registrados</span>
                    @endforelse
                </td>
            </tr>
        </table>
    </div>

    <div class="card-footer text-right">
        <a href="{{ route('cargas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>
@stop