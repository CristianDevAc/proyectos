@extends('adminlte::page')

@section('title', 'Reporte de Liquidaciones')

@section('content_header')
    <h1>📊 Reporte de Liquidaciones</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Filtrar por Cooperativa y Fechas</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.liquidaciones') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="cooperativa_id">Cooperativa Minera:</label>
                        <select name="cooperativa_id" class="form-control select2">
                            <option value="">-- Todas las Cooperativas --</option>
                            @foreach($cooperativas as $cooperativa)
                                <option value="{{ $cooperativa->id }}" {{ request('cooperativa_id') == $cooperativa->id ? 'selected' : '' }}>
                                    {{ $cooperativa->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_inicio">Fecha Inicio:</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_fin">Fecha Fin:</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($liquidaciones->count())
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cooperativa</th>
                            <th>Lote</th>
                            <th>Pb (%)</th>
                            <th>Zn (%)</th>
                            <th>Ag (g/t)</th>
                            <th>Importe Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($liquidaciones as $liq)
                            <tr>
                                <td>{{ $liq->fecha_liquidacion }}</td>
                                <td>{{ $liq->cooperativa->nombre }}</td>
                                <td>{{ $liq->carga->lote }}</td>
                                <td>{{ $liq->ley_pb }}</td>
                                <td>{{ $liq->ley_zn }}</td>
                                <td>{{ $liq->ley_ag }}</td>
                                <td class="text-right">{{ number_format($liq->importe_total, 2) }} Bs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            No se encontraron liquidaciones con los filtros seleccionados.
        </div>
    @endif
@stop