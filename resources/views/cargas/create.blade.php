@extends('adminlte::page')

@section('title', 'Registrar Carga')

@section('content_header')
    <h1>Registrar Nueva Carga</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('cargas.store') }}" method="POST">
    @csrf
    <div class="row">
    {{-- Primera Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light"><strong>Información General</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Centro de Acopio</label>
                        <select name="centro_acopio_id" class="form-control" disabled>
                            @foreach ($centrosAcopio as $centro)
                                <option selected>{{ $centrosAcopio->first()->nombre ?? 'Sin nombre' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Plataforma</label>
                        <select name="plataforma_id" class="form-control">
                            <option value="">Seleccione una plataforma</option>
                            @foreach ($plataformas as $plataforma)
                                <option value="{{ $plataforma->id }}"
                                    {{ old('plataforma_id') == $plataforma->id ? 'selected' : '' }}>
                                    {{ $plataforma->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lote</label>
                        <input type="text" name="lote" class="form-control" value="{{ old('lote') }}">
                    </div>
                    <div class="form-group">
                        <label>Producto</label>
                        <input type="text" name="producto" class="form-control" value="{{ old('producto') }}">
                    </div>
                    <div class="form-group">
                        <label>Minerales</label>
                        <div class="row">
                            @foreach ($minerales as $mineral)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input 
                                            type="checkbox" 
                                            name="minerales[]" 
                                            value="{{ $mineral->id }}" 
                                            id="mineral_{{ $mineral->id }}" 
                                            class="form-check-input"
                                            {{ in_array($mineral->id, old('minerales', [])) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="mineral_{{ $mineral->id }}">
                                            {{ $mineral->nombre }} ({{ $mineral->simbolo }})
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="form-text text-muted">Selecciona uno o varios minerales que contiene la carga.</small>
                    </div>
                    <div class="form-group">
                        <label>Fecha de registro</label>
                        <input type="date" name="fecha_registro" class="form-control" 
                            value="{{ old('fecha_registro', date('Y-m-d')) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Segunda Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light"><strong>Origen y Estado</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Número de boleta</label>
                        <input type="text" name="numero_boleta" class="form-control" value="{{ old('numero_boleta') }}">
                    </div>
                    <div class="form-group">
                        <label for="cooperativa_id">Cooperativa</label>
                        <div class="input-group">
                            <select name="cooperativa_id" id="cooperativa_id" class="form-control">
                                <option value="">Seleccione una cooperativa</option>
                                @foreach ($cooperativas as $cooperativa)
                                    <option value="{{ $cooperativa->id }}"
                                        {{ old('cooperativa_id') == $cooperativa->id ? 'selected' : '' }}>
                                        {{ $cooperativa->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCooperativa">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="concesion_mina_id">Concesión Minera</label>
                        <div class="form-row">
                            <div class="col-md-10">
                                <select name="concesion_mina_id" id="concesion_mina_id" class="form-control">
                                    <option value="">Seleccione una concesión</option>
                                    @foreach ($concesiones as $concesion)
                                        <option value="{{ $concesion->id }}"
                                            {{ old('concesion_mina_id') == $concesion->id ? 'selected' : '' }}>
                                            {{ $concesion->mina }} ({{ $concesion->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modalConcesionMina">
                                    <i class="fas fa-plus"> Nuevo</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="proveedor_id">Proveedor</label>
                        <div class="form-row">
                            <div class="col-md-10">
                                <select name="proveedor_id" id="proveedor_id" class="form-control">
                                    <option value="">Seleccione proveedor</option>
                                    @foreach ($personas as $persona)
                                        <option value="{{ $persona->id }}"
                                            {{ old('proveedor_id') == $persona->id ? 'selected' : '' }}>
                                            {{ $persona->nombre_completo }} ({{ $persona->documento }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modalProveedor">
                                    <i class="fas fa-plus"> Nuevo</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="socio_id">Socio</label>
                        <div class="form-row">
                            <div class="col-md-10">   
                                <select name="socio_id" id="socio_id" class="form-control">
                                    <option value="">Seleccione socio</option>
                                    @foreach ($personas as $persona)
                                        <option value="{{ $persona->id }}"
                                            {{ old('socio_id') == $persona->id ? 'selected' : '' }}>
                                            {{ $persona->nombre_completo }} ({{ $persona->documento }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modalSocio">
                                    <i class="fas fa-plus"> Nuevo</i>
                                </button>
                            </div>
                        </div>
                    </div>
                   <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" class="form-control">
                            <option value="PESAJE" {{ old('estado') == 'PESAJE' ? 'selected' : '' }}>PESAJE</option>
                            <option value="ACUMULACION" {{ old('estado') == 'ACUMULACION' ? 'selected' : '' }}>ACUMULACIÓN</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tercera Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light"><strong>Transporte</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Tipo de carga</label>
                        <select name="tipo" class="form-control">
                            <option value="BROSA" {{ old('tipo') == 'BROSA' ? 'selected' : '' }}>BROSA</option>
                            <option value="CONCENTRADO" {{ old('tipo') == 'CONCENTRADO' ? 'selected' : '' }}>CONCENTRADO</option>
                            <option value="SACOS" {{ old('tipo') == 'SACOS' ? 'selected' : '' }}>SACOS</option>
                        </select>
                    </div>
                    <div class="form-group" id="grupo_conductor">
                        <label for="conductor_id">Conductor</label>
                        <div class="form-row">
                            <div class="col-md-10">
                                <select name="conductor_id" id="conductor_id" class="form-control">
                                    <option value="">Seleccione conductor</option>
                                    @foreach ($personas as $persona)
                                        <option value="{{ $persona->id }}" {{ old('conductor_id') == $persona->id ? 'selected' : '' }}>
                                            {{ $persona->nombre_completo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modalConductor">
                                    <i class="fas fa-plus"> Nuevo</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="grupo_camion">
                        <label for="camion_id">Camión</label>
                        <div class="form-row align-items-center">
                            <div class="col-md-10">
                                <select name="camion_id" id="camion_id" class="form-control">
                                    <option value="">Seleccione un camión</option>
                                    @foreach ($camiones as $camion)
                                        <option value="{{ $camion->id }}" data-pesaje="{{ $camion->pesaje }}" {{ old('camion_id') == $camion->id ? 'selected' : '' }}>
                                            {{ $camion->placa }} - {{ $camion->pesaje }} kg
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modalCamion">
                                    <i class="fas fa-plus"></i> Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="grupo_sacos">
                        <label>Cantidad de sacos</label>
                        <input 
                            type="number" 
                            name="cantidad_sacos" 
                            id="cantidad_sacos" 
                            class="form-control"
                            value="{{ old('cantidad_sacos') }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        {{-- Cuarta Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light"><strong>Peso y Sacos</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Peso bruto (kg)</label>
                        <input 
                            type="number" 
                            name="peso_bruto" 
                            id="peso_bruto" 
                            class="form-control" 
                            value="{{ old('peso_bruto') }}"
                        >
                    </div>
                    <div class="form-group">
                        <label>Peso tara (kg)</label>
                        <input 
                            type="number" 
                            name="peso_tara" 
                            id="peso_tara" 
                            class="form-control" 
                            value="{{ old('peso_tara') }}"
                        >
                    </div>
                    <div class="form-group">
                        <label>Peso neto (kg)</label>
                        <input 
                            type="number" 
                            name="peso_neto" 
                            id="peso_neto" 
                            class="form-control" 
                            readonly
                            value="{{ old('peso_neto') }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        {{-- Quinta Card --}}
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light"><strong>Observaciones</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Escriba cualquier observación...">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-right mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Carga
            </button>
    </div>
</form>

    {{-- Modal Cooperativa --}}
    <div class="modal fade" id="modalCooperativa" tabindex="-1" aria-labelledby="modalCooperativaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCooperativa">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar Nueva Cooperativa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre_cooperativa">Nombre</label>
                            <input type="text" class="form-control" id="nombre_cooperativa" name="nombre" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Concesion Minera -->
    <div class="modal fade" id="modalConcesionMina" tabindex="-1" role="dialog" aria-labelledby="modalConcesionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formConcesionMina">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConcesionLabel">Registrar Concesión Minera</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="codigo_concesion">Código</label>
                            <input type="text" id="codigo_concesion" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="mina_concesion">Nombre de la Mina</label>
                            <input type="text" id="mina_concesion" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="municipio_id">Municipio</label>
                            <select id="municipio_id" class="form-control" required>
                                <option value="">Seleccione un municipio</option>
                                @foreach($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">{{ $municipio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Camión --}}
    <div class="modal fade" id="modalCamion" tabindex="-1" aria-labelledby="modalCamionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCamion">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar Nuevo Camión</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="placa_camion">Placa</label>
                            <input type="text" class="form-control" id="placa_camion" required>
                        </div>
                        <div class="form-group">
                            <label for="pesaje_camion">Pesaje</label>
                            <input type="number" class="form-control" id="pesaje_camion" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_camion">Descripción</label>
                            <textarea id="descripcion_camion" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Proveedor -->
    <div class="modal fade" id="modalProveedor" tabindex="-1" aria-labelledby="modalProveedorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formProveedor">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="modalProveedorLabel">Registrar Nuevo Proveedor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label for="documento">Documento</label>
                <input type="text" class="form-control" id="documento" name="documento" required>
            </div>
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
            </div>
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Modal de alerta genérico -->
    <div class="modal fade" id="modalAlert" tabindex="-1" aria-labelledby="modalAlertLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalAlertLabel">Mensaje</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modalAlertBody">
            <!-- Aquí irá el mensaje -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
    <!-- Modal Socio -->
    <div class="modal fade" id="modalSocio" tabindex="-1" aria-labelledby="modalSocioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formSocio">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSocioLabel">Registrar Nuevo Socio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="documento_socio">Documento</label>
                            <input type="text" class="form-control" id="documento_socio" name="documento" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre_completo_socio">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre_completo_socio" name="nombre_completo" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion_socio">Dirección</label>
                            <input type="text" class="form-control" id="direccion_socio" name="direccion">
                        </div>
                        <div class="form-group">
                            <label for="codigo_socio">Código</label>
                            <input type="text" class="form-control" id="codigo_socio" name="codigo" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono_socio">Teléfono</label>
                            <input type="text" class="form-control" id="telefono_socio" name="telefono">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Conductor -->
    <div class="modal fade" id="modalConductor" tabindex="-1" aria-labelledby="modalConductorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formConductor">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConductorLabel">Registrar Nuevo Conductor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="documento_conductor">Documento</label>
                            <input type="text" class="form-control" id="documento_conductor" name="documento" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre_completo_conductor">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre_completo_conductor" name="nombre_completo" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion_conductor">Dirección</label>
                            <input type="text" class="form-control" id="direccion_conductor" name="direccion">
                        </div>
                        <div class="form-group">
                            <label for="codigo_conductor">Código</label>
                            <input type="text" class="form-control" id="codigo_conductor" name="codigo" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono_conductor">Teléfono</label>
                            <input type="text" class="form-control" id="telefono_conductor" name="telefono">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Camión -->
    <div class="modal fade" id="modalCamion" tabindex="-1" aria-labelledby="modalCamionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCamion">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCamionLabel">Registrar Nuevo Camión</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="placa_camion">Placa</label>
                            <input type="text" class="form-control" id="placa_camion" required>
                        </div>
                        <div class="form-group">
                            <label for="pesaje_camion">Pesaje</label>
                            <input type="number" class="form-control" id="pesaje_camion" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_camion">Descripción</label>
                            <textarea id="descripcion_camion" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Para que select2 se integre bien con AdminLTE */
        .select2-container .select2-selection--single {
            height: 38px !important;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@endsection
@section('js')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // Inicializa Select2
            $('#proveedor_id').select2({
                placeholder: 'Buscar proveedor...',
                width: '100%',
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    },
                    inputTooShort: function () {
                        return "Ingrese más caracteres...";
                    }
                }
            });

            $('#socio_id').select2({
                placeholder: 'Buscar socio...',
                width: '100%',
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    },
                    inputTooShort: function () {
                        return "Ingrese más caracteres...";
                    }
                }
            });

            // Conductor
            $('#conductor_id').select2({
                placeholder: 'Buscar conductor...',
                width: '100%',
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    },
                    inputTooShort: function () {
                        return "Ingrese más caracteres...";
                    }
                }
            });
            $('#camion_id').select2({
                placeholder: 'Buscar camión...',
                width: '100%',
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    },
                    inputTooShort: function () {
                        return "Ingrese más caracteres...";
                    }
                }
            });
            $('#concesion_mina_id').select2({
                placeholder: 'Buscar concesión minera...',
                width: '100%',
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    },
                    inputTooShort: function () {
                        return "Ingrese más caracteres...";
                    }
                }
            });
           
        });
        $('#formProveedor').submit(function(e) {
            e.preventDefault();

            let formData = {
                documento: $('#documento').val(),
                nombre_completo: $('#nombre_completo').val(),
                direccion: $('#direccion').val(),
                codigo: $('#codigo').val(),
                telefono: $('#telefono').val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: "{{ route('proveedores.ajax.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Añadir nuevo proveedor al select2 y seleccionarlo
                        let newOption = new Option(response.persona.nombre_completo + ' (' + response.persona.documento + ')', response.persona.id, true, true);
                        $('#proveedor_id').append(newOption).trigger('change');

                        $('#modalProveedor').modal('hide');
                        $('#formProveedor')[0].reset();

                        // Mostrar alert dentro del modalProveedor
                        showAlert('Proveedor registrado correctamente', 'success', '#modalProveedor .modal-content');
                    } else {
                        showAlert('Error: ' + (response.message || 'Error desconocido'), 'danger', '#modalProveedor .modal-content');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = 'Errores:\n';
                    $.each(errors, function(key, val) {
                        errorMessage += val + '\n';
                    });
                    alert(errorMessage);
                }
            });
        });
        $('#formSocio').submit(function(e) {
            e.preventDefault();

            let formData = {
                documento: $('#documento_socio').val(),
                nombre_completo: $('#nombre_completo_socio').val(),
                direccion: $('#direccion_socio').val(),
                codigo: $('#codigo_socio').val(),
                telefono: $('#telefono_socio').val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: "{{ route('proveedores.ajax.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        let newOption = new Option(response.persona.nombre_completo + ' (' + response.persona.documento + ')', response.persona.id, true, true);
                        $('#socio_id').append(newOption).trigger('change');

                        $('#modalSocio').modal('hide');
                        $('#formSocio')[0].reset();
                        showAlert('Socio registrado correctamente', 'success');
                    } else {
                        showAlert('Error: ' + (response.message || 'Error desconocido'), 'danger');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    $.each(errors, function(key, val) {
                        errorMessage += val + '<br>';
                    });
                    showAlert(errorMessage, 'danger');
                }
            });
        });
        $('#formConductor').submit(function(e) {
            e.preventDefault();

            let formData = {
                documento: $('#documento_conductor').val(),
                nombre_completo: $('#nombre_completo_conductor').val(),
                direccion: $('#direccion_conductor').val(),
                codigo: $('#codigo_conductor').val(),
                telefono: $('#telefono_conductor').val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: "{{ route('proveedores.ajax.store') }}", // Crea esta ruta y controlador
                method: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        let newOption = new Option(response.persona.nombre_completo + ' (' + response.persona.documento + ')', response.persona.id, true, true);
                        $('#conductor_id').append(newOption).trigger('change');

                        $('#modalConductor').modal('hide');
                        $('#formConductor')[0].reset();
                        showAlert('Conductor registrado correctamente', 'success');
                    } else {
                        showAlert('Error: ' + (response.message || 'Error desconocido'), 'danger');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    $.each(errors, function(key, val) {
                        errorMessage += val + '<br>';
                    });
                    showAlert(errorMessage, 'danger');
                }
            });
        });
        $('#formConcesionMina').submit(function (e) {
            e.preventDefault();

            const codigo = $('#codigo_concesion').val();
            const mina = $('#mina_concesion').val();
            const municipio_id = $('#municipio_id').val();
            const token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('concesiones.ajax.store') }}",
                method: 'POST',
                data: {
                    codigo: codigo,
                    mina: mina,
                    municipio_id: municipio_id,
                    _token: token
                },
                success: function (data) {
                    if (data.success) {
                        let newOption = new Option(`${data.concesion.mina} (${data.concesion.codigo})`, data.concesion.id, true, true);
                        $('#concesion_mina_id').append(newOption).trigger('change');

                        $('#modalConcesionMina').modal('hide');
                        $('#formConcesionMina')[0].reset();

                        showAlert('Concesión Minera registrada correctamente', 'success');
                    } else {
                        showAlert('Error: ' + (data.message || 'Error desconocido'), 'danger');
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = 'Errores:\n';
                    $.each(errors, function (key, val) {
                        errorMessage += val + '\n';
                    });
                    alert(errorMessage);
                }
            });
        });
        $('#camion_id').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const pesaje = selectedOption.data('pesaje') || '';

            $('#peso_tara').val(pesaje);

            // Opcional: recalcula el peso neto si quieres
            const bruto = parseFloat($('#peso_bruto').val()) || 0;
            const tara = parseFloat(pesaje) || 0;
            const neto = bruto - tara;
            $('#peso_neto').val(neto > 0 ? neto : 0);
        });
        
    </script>
<script>
    $('#proveedor_id').select2({
        placeholder: 'Buscar proveedor...',
        allowClear: true,
        width: 'resolve' // esto hace que respete el tamaño del input-group
    });
document.getElementById('formCooperativa').addEventListener('submit', function (e) {
    e.preventDefault();

    const nombre = document.getElementById('nombre_cooperativa').value;
    const token = document.querySelector('input[name="_token"]').value;

    fetch("{{ route('cooperativas.ajax.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ nombre })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const select = document.getElementById('cooperativa_id');
            const option = document.createElement('option');
            option.value = data.cooperativa.id;
            option.text = data.cooperativa.nombre;
            option.selected = true;
            select.appendChild(option);
            $('#modalCooperativa').modal('hide');
            document.getElementById('nombre_cooperativa').value = '';
            showAlert('Cooperativa registrada correctamente', 'success');
        } else {
            showAlert('Error: ' + (data.message || 'Error desconocido'), 'danger');
        }
    })
    .catch(err => {
        showAlert('Error en la petición', 'danger');
        console.error(err);
    });
});
document.getElementById('formCamion').addEventListener('submit', function (e) {
    e.preventDefault();

    const placa = document.getElementById('placa_camion').value;
    const pesaje = document.getElementById('pesaje_camion').value;
    const descripcion = document.getElementById('descripcion_camion').value;
    const token = document.querySelector('input[name="_token"]').value;

    fetch("{{ route('camiones.ajax.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ placa, pesaje, descripcion })
    })
    .then(response => {
        if (!response.ok) return response.text().then(t => { throw new Error(t) });
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const select = document.getElementById('camion_id');

            // 👉 Agregamos opción con data-pesaje
            const option = document.createElement('option');
            option.value = data.camion.id;
            option.text = `${data.camion.placa} - ${data.camion.pesaje} kg`;
            option.setAttribute('data-pesaje', data.camion.pesaje);
            option.selected = true;
            select.appendChild(option);

            // 👉 Establecemos peso tara directamente
            document.getElementById('peso_tara').value = data.camion.pesaje;

            $('#modalCamion').modal('hide');
            document.getElementById('formCamion').reset();

            showAlert('Camión registrado correctamente', 'success');
        } else {
            showAlert('Error: ' + (data.message || 'Error desconocido'), 'danger');
        }
    })
    .catch(error => {
        console.error(error);
        showAlert('Error en la petición: ' + error.message, 'danger');
    });
});

function showAlert(message, type = 'info') {
    const modalBody = document.getElementById('modalAlertBody');
    modalBody.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
    $('#modalAlert').modal('show');
}
document.addEventListener('DOMContentLoaded', function () {
    const tipoCarga = document.querySelector('select[name="tipo"]');
    const grupoSacos = document.getElementById('grupo_sacos');
    const cantidadSacos = document.getElementById('cantidad_sacos');
    const pesoBruto = document.getElementById('peso_bruto');
    const pesoTara = document.getElementById('peso_tara');
    const pesoNeto = document.getElementById('peso_neto');

    function actualizarVisibilidadSacos() {
        const tipo = tipoCarga.value;
        if (tipo === 'SACOS') {
            grupoSacos.style.display = 'block';
            cantidadSacos.required = true;

            // Ocultar camión y conductor
            document.getElementById('grupo_camion').style.display = 'none';
            document.getElementById('grupo_conductor').style.display = 'none';

            // Limpiar selects de camión y conductor usando Select2 y resetear valor
            $('#camion_id').val(null).trigger('change');
            $('#conductor_id').val(null).trigger('change');

            // Limpiar peso tara y calcular peso neto
            pesoTara.value = '';
            calcularPesoNeto();

        } else {
            grupoSacos.style.display = 'none';
            cantidadSacos.required = false;
            cantidadSacos.value = '';

            // Mostrar camión y conductor
            document.getElementById('grupo_camion').style.display = 'block';
            document.getElementById('grupo_conductor').style.display = 'block';
        }
    }

    function limpiarPesos() {
        pesoBruto.value = '';
        pesoTara.value = '';
        pesoNeto.value = '';
    }

    function calcularPesoNeto() {
        const bruto = parseFloat(pesoBruto.value) || 0;
        const tara = parseFloat(pesoTara.value) || 0;
        const neto = bruto - tara;
        pesoNeto.value = neto > 0 ? neto : 0;
    }

    // Eventos
    tipoCarga.addEventListener('change', () => {
        actualizarVisibilidadSacos();
        limpiarPesos();
    });

    pesoBruto.addEventListener('input', calcularPesoNeto);
    pesoTara.addEventListener('input', calcularPesoNeto);

    // Inicial
    actualizarVisibilidadSacos(); // por defecto se oculta si no es SACOS
});

</script>
@stop
