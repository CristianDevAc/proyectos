@extends('adminlte::page')

@section('title', 'Listado de Cargas')

@section('content_header')
    <h1>Cargas Registradas</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <form method="GET" class="form-inline">
                    <div class="form-group mr-2">
                        <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="form-control"
                            placeholder="Buscar lote o proveedor...">
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

                @can('crear cargas')
                <a href="{{ route('cargas.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Nueva Carga
                </a>
                @endcan

            </div>

            @if($cargas->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Plataforma</th>
                            <th>Lote</th>
                            <th>Minerales</th>
                            <th>Estado</th>
                            <th>Tipo</th>
                            <th>Proveedor</th>
                            <th>Peso Neto (kg)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cargas as $carga)
                            <tr>
                                <td>{{ $carga->id }}</td>
                                <td>{{ $carga->fecha_registro->format('d/m/Y') }}</td>
                                <td>{{ $carga->plataforma->nombre ?? '-' }}</td>
                                <td>{{ $carga->lote }}</td>
                                <td>
                                    @forelse ($carga->minerales as $mineral)
                                        <span class="badge badge-primary">{{ $mineral->nombre }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if($carga->estado == 1)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>{{ $carga->tipo }}</td>
                                <td>{{ optional($carga->personas->where('pivot.tipo', 'PROVEEDOR')->first())->nombre_completo ?? '-' }}</td>
                                <td>{{ number_format($carga->peso_neto) }}</td>
                                <td>
                                   
                                    <a href="{{ route('cargas.show', $carga) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cargas.reporte', $carga->id) }}" class="btn btn-sm btn-outline-danger" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <small>
                    Mostrando {{ $cargas->firstItem() ?? 0 }} a {{ $cargas->lastItem() ?? 0 }} de {{ $cargas->total() }} registros
                </small>
                {{ $cargas->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>

            @else
                <p class="text-muted">No hay cargas registradas.</p>
            @endif

        </div>
    </div>

@stop