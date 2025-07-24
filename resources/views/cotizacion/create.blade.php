@extends('adminlte::page')

@section('title', 'Registrar Cotización')

@section('content_header')
    <h1>Nueva Cotización</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('cotizacion.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="mineral_id">Mineral</label>
                <select name="mineral_id" class="form-control" required>
                    <option value="">-- Seleccione --</option>
                    @foreach($minerales as $mineral)
                        <option value="{{ $mineral->id }}" {{ old('mineral_id') == $mineral->id ? 'selected' : '' }}>
                            {{ $mineral->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quincena">Quincena</label>
                <select name="quincena" class="form-control" required>
                    <option value="PRIMERA" {{ old('quincena') == 'PRIMERA' ? 'selected' : '' }}>PRIMERA</option>
                    <option value="SEGUNDA" {{ old('quincena') == 'SEGUNDA' ? 'selected' : '' }}>SEGUNDA</option>
                </select>
            </div>

            <div class="form-group">
                <label for="mes">Mes</label>
                <select name="mes" class="form-control" required>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('mes') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->locale('es')->monthName }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label for="gestion">Gestión (Año)</label>
                <input type="number" name="gestion" class="form-control" value="{{ old('gestion', date('Y')) }}" required>
            </div>

            <div class="form-group">
                <label for="valor">Valor en $us</label>
                <input type="number" step="0.01" name="valor" class="form-control" value="{{ old('valor') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Registrar
            </button>
            <a href="{{ route('cotizacion.index') }}" class="btn btn-secondary">Cancelar</a>

        </form>

    </div>
</div>

@stop