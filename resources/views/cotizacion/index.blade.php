@extends('adminlte::page')

@section('title', 'Cotizaciones')

@section('content_header')
    <h1>Cotizaciones de Minerales</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <!-- Buscador, selector y botón nueva cotización -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <form method="GET" class="form-inline">
                <div class="form-group mr-2">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="form-control"
                        placeholder="Buscar por mineral o gestión">
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

            <a href="{{ route('cotizacion.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Nueva Cotización
            </a>

        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Mineral</th>
                        <th>Quincena</th>
                        <th>Mes</th>
                        <th>Gestión</th>
                        <th>Valor ($us)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cotizaciones as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->mineral->nombre ?? 'N/D' }}</td>
                            <td>{{ $item->quincena }}</td>
                            <td>{{ \Carbon\Carbon::create()->month($item->mes)->locale('es')->monthName }}</td>
                            <td>{{ $item->gestion }}</td>
                            <td>{{ number_format($item->valor, 2) }}</td>
                            <td>
                                <a href="{{ route('cotizacion.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cotizacion.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('¿Deseas eliminar esta cotización?')" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No se encontraron registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginador y total -->
        <div class="d-flex justify-content-between align-items-center">
            <small>
                Mostrando {{ $cotizaciones->firstItem() ?? 0 }} a {{ $cotizaciones->lastItem() ?? 0 }} de {{ $cotizaciones->total() }} registros
            </small>
            {{ $cotizaciones->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>

    </div>
</div>

@stop