@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.usuarios.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Nueva Contraseña <small>(dejar vacío para no cambiar)</small></label>
            <input type="password" name="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label>Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label>Rol</label>
            <select name="role" class="form-control" required>
                <option value="">Seleccione un rol</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ (old('role', $user->roles->pluck('name')->first()) == $role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
@stop
