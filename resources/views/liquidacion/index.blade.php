@extends('adminlte::page')

@section('title', 'Liquidaciones')

@section('content_header')
    <h1>Liquidaciones</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <!-- Buscador, selector y botón nueva liquidación -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <form method="GET" class="form-inline">
                <div class="form-group mr-2">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="form-control"
                        placeholder="Buscar por lote o fecha">
                </div>
                <div class="form-group mr-2">
                    <select name="per_page" class="form-control">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>

            <a href="{{ route('liquidacion.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Nueva Liquidación
            </a>

        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Lote</th>
                        <th>Fecha Liquidación</th>
                        <th>Fecha Carga</th>
                        <th>Peso Húmedo</th>
                        <th>Peso Seco</th>
                        <th>Valor kilo bs</th>
                        <th>Importe</th>
                        <th>Total deduciones</th>
                        <th>Regalia</th>
                        <th>Liquido Pagable</th>
                        <th>Valor Bruto Compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($liquidaciones as $liquidacion)
                        <tr>
                            <td>{{ $liquidacion->id }}</td>
                            <td>{{ $liquidacion->carga->lote ?? 'N/A' }}</td>
                            <td>{{ $liquidacion->fecha_liquidacion->format('d/m/Y') }}</td>
                            <td>{{ $liquidacion->carga->fecha_registro->format('d/m/Y') }}</td>
                            <td>{{ number_format($liquidacion->peso_humedo, 2) }}</td>
                            <td>{{ number_format($liquidacion->peso_seco, 2) }}</td>
                            <td>bs{{ number_format($liquidacion->valor_tonelada_bs, 2) }}</td>
                            <td>bs{{ number_format($liquidacion->importe_total, 2) }}</td>
                            <td>bs{{ number_format($liquidacion->total_deducciones, 2) }}</td>
                            <td>bs{{ number_format($liquidacion->total_regalia, 2) }}</td>
                            <td>bs{{ number_format($liquidacion->liquido_pagable, 2) }}</td>
                            <td>bs{{ number_format($liquidacion->valor_bruto_compra, 2) }}</td>
                            <td>
                                <a href="{{ route('liquidaciones.show', $liquidacion) }}" class="btn btn-sm btn-info" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('liquidaciones.pdf', $liquidacion->id) }}" class="btn btn-sm btn-secondary" title="Ver PDF" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No se encontraron registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginador y total -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small>
                Mostrando {{ $liquidaciones->firstItem() ?? 0 }} a {{ $liquidaciones->lastItem() ?? 0 }} de {{ $liquidaciones->total() }} registros
            </small>
            {{ $liquidaciones->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>

    </div>
</div>

@stop