@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Gestión de Usuarios</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
            <td>
                <a href="{{ route('admin.usuarios.edit', $user) }}" class="btn btn-sm btn-primary">Editar Rol</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('admin.usuarios.create') }}" class="btn btn-success mb-3">
    <i class="fas fa-user-plus"></i> Nuevo Usuario
</a>
@stop
