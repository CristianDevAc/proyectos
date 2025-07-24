@extends('adminlte::page')

@section('title', 'Muestras de Laboratorio')

@section('content_header')
    <h1>Muestras de Laboratorio</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <!-- Buscador, selector y botón nueva muestra -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <form method="GET" class="form-inline">
                <div class="form-group mr-2">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="form-control"
                        placeholder="Buscar por lote o cliente">
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

            <a href="{{ route('muestras.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Nueva Muestra
            </a>

        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Lote</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($muestras as $muestra)
                        <tr>
                            <td>{{ $muestra->id }}</td>
                            <td>{{ $muestra->carga->lote ?? 'N/A' }}</td>
                            <td>{{ $muestra->carga->personas->first()->nombre_completo ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($muestra->fecha_muestra)->format('d/m/Y') }}</td>
                            <td>
                                @if($muestra->estado == 1)
                                    <span class="badge badge-success">Utilizado</span>
                                @else
                                    <span class="badge badge-danger">No utilizado</span>
                                @endif
                            </td>
                            <td>{{ $muestra->tipo }}</td>
                            <td>
                                <a href="{{ route('muestras.show', $muestra) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('muestras.edit', $muestra) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No se encontraron registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginador y total -->
        <div class="d-flex justify-content-between align-items-center">
            <small>
                Mostrando {{ $muestras->firstItem() ?? 0 }} a {{ $muestras->lastItem() ?? 0 }} de {{ $muestras->total() }} registros
            </small>
            {{ $muestras->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>

    </div>
</div>

@stop