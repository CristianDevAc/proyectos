@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1>Panel de Reportes</h1>
@stop

@section('content')

<div class="row">

    {{-- Reporte Personalizado --}}
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Reporte Personalizado</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reportes.filtrar') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="cooperativa_id">Cooperativa Minera</label>
                        <select name="cooperativa_id" id="cooperativa_id" class="form-control select2" required>
                            <option value="">Seleccione una cooperativa</option>
                            @foreach ($cooperativas as $cooperativa)
                                <option value="{{ $cooperativa->id }}">{{ $cooperativa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-search"></i> Generar Reporte
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Reporte M02 --}}
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Reporte M02</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reportes.m02') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="cooperativa_id_m02">Cooperativa Minera</label>
                        <select name="cooperativa_id" id="cooperativa_id_m02" class="form-control select2" required>
                            <option value="">Seleccione una cooperativa</option>
                            @foreach ($cooperativas as $cooperativa)
                                <option value="{{ $cooperativa->id }}">{{ $cooperativa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quincena">Quincena</label>
                        <select name="quincena" id="quincena" class="form-control" required>
                            <option value="1">Primera (1-15)</option>
                            <option value="2">Segunda (16-Fin de mes)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mes">Mes</label>
                        <select name="mes" id="mes" class="form-control" required>
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gestion">Gestión</label>
                        <input type="number" name="gestion" id="gestion" min="2000" max="2100"
                               class="form-control" value="{{ now()->year }}" required>
                    </div>

                    <button type="submit" class="btn btn-dark btn-block">
                        <i class="fas fa-file-alt"></i> Generar Reporte M02
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@stop