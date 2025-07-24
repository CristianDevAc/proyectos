@extends('adminlte::page')

@section('title', 'Registrar Liquidación')

@section('content_header')
    <h1>Registrar Nueva Liquidación</h1>
@stop

@section('content')
<div class="col-md-12">
    <form method="POST" action="{{ route('liquidaciones.store') }}" id="formLiquidacion">
            @csrf
<div class="row">
    <!-- Columna Principal: Formulario -->
    <div class="col-9">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        

            <!-- Tarjeta Selección Carga -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <strong>Seleccionar Carga (por lote y proveedor)</strong>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="carga_id">Buscar Carga (Lote - Proveedor):</label>
                        <select id="carga_id" name="carga_id" class="form-control select2 @error('carga_id') is-invalid @enderror" required>
                            <option value="">-- Seleccione una carga --</option>
                            @foreach ($cargas as $carga)
                                @php
                                    $proveedor = $carga->personas->firstWhere('pivot.tipo', 'PROVEEDOR')->nombre_completo ?? 'Sin proveedor';
                                    $socio = $carga->personas->firstWhere('pivot.tipo', 'SOCIO')->nombre_completo ?? 'Sin socio';
                                    $tieneMuestra = $carga->muestrasLaboratorio->count() > 0 ? 'MUESTRA SI' : 'MUESTRA NO';
                                @endphp
                               <option value="{{ $carga->id }}"
                                    data-lote="{{ $carga->lote }}"
                                    data-proveedor="{{ $proveedor }}"
                                    data-socio="{{ $socio }}"
                                    data-cooperativa-id="{{ $carga->cooperativa_id }}"
                                    data-concesion-id="{{ $carga->concesion_mina_id }}"
                                    data-peso-neto="{{ $carga->peso_neto }}">
                                    {{ $carga->lote }} - PROVEEDOR: {{ $proveedor }}
                                </option>
                            @endforeach
                        </select>
                        @error('carga_id')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tarjeta Datos Liquidación -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Datos de la Liquidación
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Lote -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lote">Lote</label>
                                <input type="text" class="form-control" id="lote" name="lote" readonly>
                            </div>
                        </div>

                        <!-- Cooperativa -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cooperativa_id">Cooperativa</label>
                                <select name="cooperativa_id" id="cooperativa_id" class="form-control">
                                    <option value="">Seleccione una cooperativa</option>
                                    @foreach ($cooperativas as $cooperativa)
                                        <option value="{{ $cooperativa->id }}">{{ $cooperativa->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_liquidacion">Fecha de Liquidación</label>
                                <input type="date" name="fecha_liquidacion" id="fecha_liquidacion"
                                    class="form-control" required value="">
                            </div>
                        </div>

                        <!-- Proveedor -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proveedor_texto">Proveedor</label>
                                <input type="text" class="form-control" id="proveedor_texto" name="proveedor_texto" readonly>
                            </div>
                        </div>

                        <!-- Socio -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="socio_texto">Socio</label>
                                <input type="text" class="form-control" id="socio_texto" name="socio_texto" readonly>
                            </div>
                        </div>

                        <!-- Concesión -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="concesion_mina_id">Concesión Minera</label>
                                <div class="row">
                                    <div class="col-10">
                                        <select name="concesion_mina_id" id="concesion_mina_id" class="form-control">
                                            <option value="">Seleccione una concesión</option>
                                            @foreach ($concesiones as $concesion)
                                                <option value="{{ $concesion->id }}">{{ $concesion->mina }} ({{ $concesion->codigo }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-primary w-100" data-toggle="modal" data-target="#modalConcesionMina">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <!-- CARD IZQUIERDA (7 columnas) -->
                <div class="col-md-7">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            Detalle de Pesaje
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                
                                <!-- Peso Húmedo -->
                                <div class="form-group col-md-5">
                                    <label for="peso_humedo">Peso Húmedo (kg)</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="peso_humedo" name="peso_humedo" readonly>
                                </div>

                                <!-- Humedad (%) -->
                                <div class="form-group col-md-2">
                                    <label for="humedad">Humedad (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-control"
                                        id="humedad" name="humedad" required>
                                </div>

                                <!-- Peso Seco -->
                                <div class="form-group col-md-5">
                                    <label for="peso_seco">Peso Seco (kg)</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="peso_seco" name="peso_seco" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            Deducciones Aplicadas
                        </div>

                        <div class="card-body" id="contenedorDeducciones">
                            <!-- Las contribuciones seleccionadas aparecerán aquí -->
                        </div>

                        <small class="text-muted">
                            Los precios se calculan automáticamente según el importe total.
                        </small>
                    </div>
                </div>

                <!-- CARD DERECHA (5 columnas) -->
                <div class="col-md-5">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            Otros Datos / Opciones
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Columna 1: Minerales -->
                                <div class="col-md-6">
                                    <h6 class="small fw-bold text-primary">Leyes mimerales</h6>
                                    <div id="listaMinerales">
                                        <!-- Aquí se listarán los minerales vía JS -->
                                    </div>
                                </div>

                                <!-- Columna 2: Valores de tonelada -->
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="valor_tonelada_bs" class="small">Precio x Kilo (Bs)</label>
                                        <input type="number" step="0.0001" min="0" class="form-control form-control-sm" name='valor_tonelada_bs' id="valor_tonelada_bs" name="valor_tonelada_bs" readonly>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="importe_total" class="small">Importe</label>
                                        <input type="number" step="0.01" id="importe_total" name='importe_total' class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="total_deducciones" class="small">Total Deducciones</label>
                                        <input type="number" step="0.01" name='total_deducciones' id="total_deducciones" class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="tipo_regalia" class="small fw-bold">Tipo de Regalía Minera</label>
                                        <select id="tipo_regalia" class="form-control form-control-sm" name='tipo_regalia'>
                                            <option value="oficial" selected>Regalía Oficial</option>
                                            <option value="porcentaje">Regalía Porcentaje</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2" id="porcentaje_regalia_container" style="display:none;">
                                        <label for="porcentaje_regalia" class="small fw-bold">Porcentaje de Regalía (%)</label>
                                        <input type="number" step="0.01" name='porcentaje_regalia' min="0" max="100" id="porcentaje_regalia" class="form-control form-control-sm" value="0">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="regalia_minera" class="small">Regalía Minera</label>
                                        <input type="number" step="0.01" name='regalia_minera' id="regalia_minera" class="form-control form-control-sm" readonly>
                                    </div>
                                    <input type="hidden" name="muestra" id="muestra" value="0">
                                </div>
                            </div>
                           <div class="form-group mb-2">
                                <label for="liquido_pagable" class="small fw-bold text-primary">💰 Líquido Pagable (Bs)</label>
                                <input type="number" step="0.01" id="liquido_pagable" name='liquido_pagable'
                                    class="form-control form-control-lg text-center fw-bold bg-success text-white border-3 border-dark shadow-lg"
                                    style="font-size: 1.5rem;" readonly>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
    </div>

    <!-- Columna Lateral: Panel de Resumen -->
    <div class="col-3">
        <div class="card h-100 sticky-top" style="top: 20px;">
            <div class="card-header bg-secondary text-white">
                Cotizaciones/Alicuotas/Muestras
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="text-primary border-bottom pb-2 mb-3">Alícuotas</h4>
                        <div id="alicuotas">
                            <p class="text-muted mb-0">Seleccione una carga para ver sus minerales y alícuotas.</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-primary border-bottom pb-2 mb-3">Cotizaciones Senarecom</h4>
                        <div id="precio">
                            <p class="text-muted mb-0">Seleccione fecha para ver las cotizaciones Senarecom.</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-primary border-bottom pb-2 mb-3">Laboratorios</h4>
                        <div id="laboratorio">
                            <p class="text-muted mb-0">Seleccione carga para ver sus laboratorios.</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-toggle="modal" data-target="#modalContribuciones">
                            <i class="fas fa-plus"></i> Agregar Deducciones Adicionales
                        </button>
                    </div>
                    <div class="mb-4">
                        <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalAgregarContribucion">
                            Nueva Contribución
                        </button>
                    </div>
                    <div class="form-group mt-4">
                        <label for="importe_total">Valor Bruto Compra</label>
                        <input type="number" step="0.01" name='valor_bruto_compra' id="valor_bruto_compra" class="form-control" readonly>
                    </div>
                </div>
                
            </div>
            
        </div>
        
    </div>
</div>
<button type="submit" class="btn btn-success btn-block">Guardar Liquidación</button>
</form>
</div>

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
        <!-- Modal para ver imagen -->
        <div class="modal fade" id="modalImagenLaboratorio" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Certificado del Laboratorio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="imagenLaboratorioVista" src="" alt="Certificado de laboratorio" style="width:100%; max-height:500px; object-fit:contain;">
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalContribuciones" tabindex="-1" role="dialog" aria-labelledby="modalContribucionesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Deducciones Adicionales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table" id="tablaContribucionesModal">
                            <thead>
                                <tr>
                                    <th>Contribución</th>
                                    <th>Valor (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se cargará vía JS -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button id="btnSeleccionarContribuciones" class="btn btn-primary btn-sm mt-2">
                            Seleccionar y Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAgregarContribucion" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Registrar Nueva Contribución</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="formAgregarContribucion">
                            @csrf
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" id="nombre_contribucion" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="descripcion" id="descripcion_contribucion" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Valor (%)</label>
                                <input type="number" name="valor" id="valor_contribucion" step="0.01" min="0" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Contribución</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
</div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .form-group {
            margin-bottom: 0.5rem;
        }
        input.form-control,
        select.form-control {
            height: calc(1.5em + 0.75rem + 2px);
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }
        .card-body {
            padding: 0.75rem;
        }
        label {
            margin-bottom: 0.2rem;
            font-size: 0.85rem;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        
         $(document).ready(function () {

        // --- Inicialización de Select2 ---
            inicializarSelect2('#carga_id', 'Buscar carga...');
            inicializarSelect2('#concesion_mina_id', 'Buscar concesión minera...');

            // --- Formularios con AJAX ---
            $('#formConcesionMina').submit(guardarConcesionMina);
            $('#formAgregarContribucion').submit(guardarContribucion);
            document.getElementById('formCooperativa').addEventListener('submit', guardarCooperativa);

            // --- Modal Seleccionar Contribuciones ---
            $('#modalContribuciones').on('shown.bs.modal', function () {
                cargarContribuciones();
            });

            // --- Selección de contribuciones (agregar a tabla) ---
            $('#agregarContribucionesBtn').click(agregarContribucionesAFormulario);

            // --- Cambio de carga ---
            $('#carga_id').on('change', cargaSeleccionada);

            // --- Función para mostrar imagen de laboratorio ---
            $(document).on('click', '.ver-imagen-btn', function () {
                const imagenSrc = $(this).data('imagen');
                $('#imagenLaboratorioVista').attr('src', imagenSrc);
                $('#modalImagenLaboratorio').modal('show');
            });
            $('#btnSeleccionarContribuciones').click(function () {
                const contenedorDeducciones = $('#contenedorDeducciones');
                const importeTotal = parseFloat($('#importe_total').val()) || 0;
                contenedorDeducciones.empty();

                let totalDeducciones = 0; // Acumulador
                let index = 0; // Para indexar los inputs

                // Limpiar inputs ocultos anteriores
                $('input[name^="contribuciones"]').remove();

                $('.contribucion-checkbox').each(function () {
                    if ($(this).is(':checked')) {
                        const nombre = $(this).data('nombre');
                        const valor = parseFloat($(this).data('valor')) || 0;
                        const id = $(this).val();
                        const descuentoCalculado = ((importeTotal * valor) / 100).toFixed(2);

                        totalDeducciones += parseFloat(descuentoCalculado); // Acumular

                        const itemHTML = `
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><strong>${nombre}</strong> (${valor}%)</span>
                                    <input type="text" class="form-control form-control-sm text-right w-25" 
                                        value="$${descuentoCalculado}" readonly>
                                </div>
                            </div>
                        `;

                        contenedorDeducciones.append(itemHTML);

                        // 🔽 Agregar inputs ocultos para enviar al backend
                        const inputHTML = `
                            <input type="hidden" name="contribuciones[${index}][id]" value="${id}">
                            <input type="hidden" name="contribuciones[${index}][porcentaje]" value="${valor}">
                            <input type="hidden" name="contribuciones[${index}][precio]" value="${descuentoCalculado}">
                        `;
                        $('#formLiquidacion').append(inputHTML);

                        index++;
                    }
                });

                // Mostrar el total de deducciones en el input correspondiente
                $('#total_deducciones').val(totalDeducciones.toFixed(2));
                calcularLiquidoPagable();

                // Cerrar el modal
                $('#modalContribuciones').modal('hide');
            });
            $('#importe_total').on('input', function () {
                actualizarDeduccionesAplicadas();
            });
            $('#humedad').on('input', function() {
                calcularPesoSeco();
                actualizarImporteTotal();
            });
            $('#valor_tonelada_bs').on('input', function() {
                actualizarImporteTotal();
            });
            $('#fecha_liquidacion').on('change', function() {
                const cargaId = $('#carga_id').val();
                if (cargaId) {
                    cargarCotizaciones(cargaId);
                }
            });
            $('#peso_seco').on('input', calcularValorBrutoTotal);
            $(document).on('input', 'input[id^="LEY_"]', calcularValorBrutoTotal);
            $('#tipo_regalia').on('change', function() {
                const tipo = $(this).val();
                if (tipo === 'porcentaje') {
                    $('#porcentaje_regalia_container').show();
                } else {
                    $('#porcentaje_regalia_container').hide();
                    $('#porcentaje_regalia').val(0);
                }
                calcularRegaliaYLiquido();
            });

            // Al cambiar el porcentaje manualmente recalculamos
            $('#porcentaje_regalia').on('input', function() {
                calcularRegaliaYLiquido();
            });
       });

    // ---------- Funciones ----------
    
    function inicializarSelect2(selector, placeholder) {
        $(selector).select2({
            placeholder: placeholder,
            width: '100%',
            language: {
                noResults: () => "No se encontraron resultados",
                searching: () => "Buscando...",
                inputTooShort: () => "Ingrese más caracteres..."
            }
        });
    }

    function guardarConcesionMina(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('concesiones.ajax.store') }}",
            method: 'POST',
            data: {
                codigo: $('#codigo_concesion').val(),
                mina: $('#mina_concesion').val(),
                municipio_id: $('#municipio_id').val(),
                _token: $('input[name="_token"]').val()
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
                alert("❌ Ocurrió un error al registrar concesión.");
            }
        });
    }

    function guardarContribucion(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('contribuciones.store') }}",
            type: "POST",
            data: {
                _token: $('input[name="_token"]').val(),
                nombre: $('#nombre_contribucion').val(),
                descripcion: $('#descripcion_contribucion').val(),
                valor: $('#valor_contribucion').val()
            },
            success: function (response) {
                if (response.success) {
                    alert("✅ Contribución registrada.");
                    $('#formAgregarContribucion')[0].reset();
                    $('#modalAgregarContribucion').modal('hide');
                } else {
                    alert("⚠️ Error al guardar contribución.");
                }
            },
            error: function () {
                alert("❌ Error en el registro.");
            }
        });
    }

    function guardarCooperativa(e) {
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
        });
    }

    function cargarContribuciones() {
        $.ajax({
            url: '/contribuciones/listar',
            method: 'GET',
            success: function (response) {
                const tabla = $('#tablaContribucionesModal tbody');
                tabla.empty();

                response.contribuciones.forEach(function (contribucion) {
                    const checked = contribucion.inicial == 1 ? 'checked' : '';  // Solo marcado, editable siempre

                    tabla.append(`
                        <tr>
                            <td>
                                <input type="checkbox" class="contribucion-checkbox"
                                    value="${contribucion.id}"
                                    data-nombre="${contribucion.nombre}"
                                    data-valor="${contribucion.valor}"
                                    ${checked}>
                                ${contribucion.nombre}
                            </td>
                            <td class="text-center">${contribucion.valor}%</td>
                        </tr>
                    `);
                });
            },
            error: function () {
                alert('No se pudieron cargar las contribuciones.');
            }
        });
    }

    function agregarContribucionesAFormulario() {
        $('.contribucion-checkbox').each(function () {
            const id = $(this).val();
            const nombre = $(this).data('nombre');
            const valor = $(this).data('valor');

            if ($(this).is(':checked')) {
                if ($(`#contribucion-fila-${id}`).length === 0) {
                    const nuevaFila = `
                        <tr id="contribucion-fila-${id}">
                            <td>
                                ${nombre}
                                <input type="hidden" name="contribuciones[${id}][id]" value="${id}">
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control form-control-sm text-center" value="${valor}" readonly>
                                <input type="hidden" name="contribuciones[${id}][porcentaje]" value="${valor}">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="contribuciones[${id}][precio]" class="form-control form-control-sm" required>
                            </td>
                        </tr>
                    `;
                    $('#tablaContribuciones tbody').append(nuevaFila);
                }
            }
        });
        $('#modalSeleccionarContribuciones').modal('hide');
    }

    function cargaSeleccionada() {
        const cargaId = $('#carga_id').val();

        if ($('#fecha_liquidacion').val() === '') {
            $('#fecha_liquidacion').val(new Date().toISOString().split('T')[0]);
        }

        if (!cargaId) {
            $('#detalleMinerales').empty();
            $('#peso_humedo').val('');
            $('#peso_seco').val('');
            desactivarValorTonelada();
            return;
        }

        const selected = $('#carga_id').find(':selected');

        $('#lote').val(selected.data('lote') || '');
        $('#proveedor_texto').val(selected.data('proveedor') || '');
        $('#socio_texto').val(selected.data('socio') || '');
        $('#cooperativa_id').val(selected.data('cooperativa-id') || '').trigger('change');
        $('#concesion_mina_id').val(selected.data('concesion-id') || '').trigger('change');

        // Asignar peso_neto al campo peso_humedo (no editable)
        let pesoNeto = parseFloat(selected.data('peso-neto')) || 0;
        $('#peso_humedo').val(pesoNeto.toFixed(2));

        // Calcular peso seco con humedad actual
        calcularPesoSeco();

        // Cargar otros datos
        cargarMinerales(cargaId);
        cargarMineralesConInputs(cargaId);
        cargarCotizaciones(cargaId);
        cargarLaboratorios(cargaId);
        
    }

    function cargarMinerales(cargaId) {
        $.ajax({
            url: `/api/cargas/${cargaId}/minerales`,
            method: 'GET',
            success: function (minerales) {
                const detalleContainer = $('#alicuotas');
                detalleContainer.empty();
                if (minerales.length > 0) {
                    let html = '<ul class="list-group">';
                    minerales.forEach(mineral => {
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                    ${mineral.nombre}
                                    <span class="badge badge-primary badge-pill">${mineral.alicuota}%</span>
                                </li>`;
                    });
                    html += '</ul>';
                    detalleContainer.append(html);
                } else {
                    detalleContainer.html('<p class="text-muted">Esta carga no tiene minerales registrados.</p>');
                }
            },
            error: function () {
                $('#alicuotas').html('<p class="text-danger">Error al cargar los minerales.</p>');
            }
        });
    }

    function cargarCotizaciones(cargaId) {
        const fechaLiquidacion = $('#fecha_liquidacion').val();
        $.ajax({
            url: `/api/cargas/${cargaId}/cotizaciones/${fechaLiquidacion}`,
            method: 'GET',
            success: function (datos) {
                let html = '';
                let hiddenInputs = '';

                if (datos.length > 0) {
                    const { gestion, mes, quincena } = datos[0];
                    html += `<div class="mb-2">
                                <strong>Gestión:</strong> ${gestion} | 
                                <strong>Mes:</strong> ${mes} | 
                                <strong>Quincena:</strong> ${quincena}
                            </div>`;
                }

                html += '<ul class="list-group">';

                datos.forEach(item => {
                    const nombreLimpio = item.mineral_nombre.replace(/\s+/g, '_').replace(/[^a-zA-Z0-9_]/g, '');
                    const valorCotizacion = item.valor_cotizacion || 0;

                    html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                ${item.mineral_nombre} (${item.quincena})
                                <span class="badge badge-success badge-pill">
                                    ${valorCotizacion || 'No registrada'}
                                </span>
                            </li>`;

                    hiddenInputs += `<input type="hidden" id="COTIZACION_${nombreLimpio}" value="${valorCotizacion}">`;
                });

                html += '</ul>';
                $('#precio').html(html + hiddenInputs);

                // ✅ Ahora que ya existen los inputs, ejecuta el cálculo
                calcularValorBrutoTotal();
            },
            error: function () {
                $('#precio').html('<p class="text-danger">Error al cargar cotizaciones.</p>');
            }
        });
    }

    function cargarLaboratorios(cargaId) {
        $.ajax({
            url: `/api/cargas/${cargaId}/laboratorios`,
            method: 'GET',
            success: function (laboratorios) {
                const contenedor = $('#laboratorio');
                contenedor.empty();

                if (laboratorios.length > 0) {
                    let html = '<ul class="list-group">';

                    laboratorios.forEach(function (lab, index) {
                        const checked = index === 0 ? 'checked' : '';
                        const boton = lab.imagen_url
                            ? `<button type="button" class="btn btn-sm btn-primary ver-imagen-btn me-3" data-imagen="${lab.imagen_url}">Ver</button>`
                            : `<span class="text-muted me-3">Sin imagen</span>`;

                        html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    ${lab.fecha_laboratorio} - ${lab.tipo}
                                    ${boton}
                                    <input type="radio" name="muestra" value="${lab.id}" class="ms-4" ${checked}>
                                    <label class="ms-1">Elegir</label>
                                </div>
                            </li>
                        `;
                    });

                    html += '</ul>';
                    contenedor.html(html);
                } else {
                    contenedor.html('<p class="text-muted">No se encontraron laboratorios.</p>');
                }
            },
            error: function () {
                $('#laboratorio').html('<p class="text-danger">Error al cargar laboratorios.</p>');
            }
        });
    }
    function actualizarDeduccionesAplicadas() {
        const contenedor = $('#contenedorDeducciones');
        const importeTotal = parseFloat($('#importe_total').val()) || 0;
        contenedor.empty();
        $('.contribucion-checkbox:checked').each(function () {
            const nombre = $(this).data('nombre');
            const valor = parseFloat($(this).data('valor')) || 0;
            const deduccionCalculada = ((importeTotal * valor) / 100).toFixed(2);

            const bloque = `
                <div class="mb-2">
                    <strong>${nombre}</strong> - ${valor}% 
                    <input type="text" class="form-control form-control-sm text-right" 
                        value="${deduccionCalculada}" readonly>
                </div>
            `;
            contenedor.append(bloque);
        });
    }
    function cargarPesoHumedo(pesoNeto) {
        $('#peso_humedo').val(pesoNeto.toFixed(2));  // Muestra siempre con 2 decimales
        calcularPesoSeco();  // recalcula peso seco al cargar peso húmedo
    }

    function showAlert(message, type = 'info') {
        alert(message); // Puedes implementar tu propio sistema de alertas tipo Toast aquí
    }
    function calcularPesoSeco() {
        let pesoHumedo = parseFloat($('#peso_humedo').val()) || 0;
        let humedad = parseFloat($('#humedad').val()) || 0;

        let pesoSeco = pesoHumedo - ((pesoHumedo * humedad) / 100);
        if (pesoSeco < 0) pesoSeco = 0;

        $('#peso_seco').val(pesoSeco.toFixed(2));

        if (pesoSeco > 0) {
            $('#valor_tonelada_bs').prop('readonly', false);
        } else {
            $('#valor_tonelada_bs').val('');
            $('#valor_tonelada_bs').prop('readonly', true);
        }
    }
    function activarValorTonelada() {
        $('#valor_tonelada_bs').prop('readonly', false);
    }

    function desactivarValorTonelada() {
        $('#valor_tonelada_bs').val('');
        $('#valor_tonelada_bs').prop('readonly', true);
    }
    function cargarMineralesConInputs(cargaId) {
        $.ajax({
            url: `/api/cargas/${cargaId}/minerales`,
            method: 'GET',
            success: function (minerales) {
                const listaContainer = $('#listaMinerales');
                listaContainer.empty();

                if (minerales.length > 0) {
                    let html = '<div class="list-group">';

                    minerales.forEach(mineral => {
                        const nombreLimpio = mineral.nombre.replace(/\s+/g, '_').replace(/[^a-zA-Z0-9_]/g, '');
                        console.log(mineral.nombre);
                        console.log(mineral.conversion);
                        const fraccion = (parseFloat(mineral.conversion) === 32.1507) ? 1000 : 100;

                        html += `
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${mineral.nombre}</span>
                                <input type="number"
                                    id="LEY_${nombreLimpio}"
                                    name="minerales[${mineral.id}]"
                                    step="0.0001"
                                    min="0"
                                    class="form-control form-control-sm"
                                    style="width: 100px;"
                                    placeholder="0.00">
                            </div>
                            <input type="hidden" id="CONVERSION_${nombreLimpio}" value="${mineral.conversion}">
                            <input type="hidden" id="FRACCION_${nombreLimpio}" value="${fraccion}">
                            <input type="hidden" id="ALICUOTA_${nombreLimpio}" value="${mineral.alicuota}">
                        `;
                    });

                    html += '</div>';
                    listaContainer.append(html);

                    // ✅ Ahora que los inputs existen, activar escuchadores
                    $(document).on('input', 'input[id^="LEY_"]', calcularValorBrutoTotal);
                    calcularValorBrutoTotal(); // Ejecuta con valores iniciales
                } else {
                    listaContainer.html('<p class="text-muted">Esta carga no tiene minerales registrados.</p>');
                }
            },
            error: function () {
                $('#listaMinerales').html('<p class="text-danger">Error al cargar los minerales.</p>');
            }
        });
    }
    function actualizarImporteTotal() {
        const valorTonelada = parseFloat($('#valor_tonelada_bs').val()) || 0;
        const pesoSeco = parseFloat($('#peso_seco').val()) || 0;

        const importeTotal = valorTonelada * pesoSeco;

        $('#importe_total').val(importeTotal.toFixed(2));
        calcularLiquidoPagable()
    }
    function calcularValorBrutoTotal() {
        const pesoSeco = parseFloat($('#peso_seco').val()) || 0;
        let totalVBV = 0;
        let totalRegaliaMinera = 0;

        $('[id^="LEY_"]').each(function () {
            const ley = parseFloat($(this).val()) || 0;
            const idMineral = $(this).attr('id').replace('LEY_', '');

            const conversion = parseFloat($(`#CONVERSION_${idMineral}`).val()) || 0;
            const fraccion = parseFloat($(`#FRACCION_${idMineral}`).val()) || 1;
            const cotizacion = parseFloat($(`#COTIZACION_${idMineral}`).val()) || 0;
            const alicuota = parseFloat($(`#ALICUOTA_${idMineral}`).val()) || 0;   // 👈 Asegúrate de tener este hidden input

            if (ley > 0 && conversion > 0 && cotizacion > 0) {
                const resultado = (pesoSeco * (ley / fraccion)) * conversion;
                const vbvMineral = resultado * cotizacion * 6.96;

                totalVBV += vbvMineral;

                // Cálculo de regalía minera de este mineral
                const regaliaMineral = vbvMineral * (alicuota / 100);
                totalRegaliaMinera += regaliaMineral;
            }
        });

        $('#valor_bruto_compra').val(totalVBV.toFixed(2));
        $('#regalia_minera').val(totalRegaliaMinera.toFixed(2));  // 👈 Mostrar Regalía Minera total
        calcularLiquidoPagable();
        calcularRegaliaYLiquido();

    }
    function calcularLiquidoPagable() {
        const importeTotal = parseFloat($('#importe_total').val()) || 0;
        const totalDeducciones = parseFloat($('#total_deducciones').val()) || 0;
        const regaliaMinera = parseFloat($('#regalia_minera').val()) || 0;

        const liquidoPagable = importeTotal - totalDeducciones - regaliaMinera;

        $('#liquido_pagable').val(liquidoPagable.toFixed(2));
        }
        function calcularRegaliaYLiquido() {
        const tipo = $('#tipo_regalia').val();
        const importeTotal = parseFloat($('#importe_total').val()) || 0;
        const totalDeducciones = parseFloat($('#total_deducciones').val()) || 0;
        const valorBrutoCompra = parseFloat($('#valor_bruto_compra').val()) || 0;

        let totalRegalia = 0;

        if (tipo === 'oficial') {
            // Regalía oficial: sumamos los minerales (VBVmineral * alicuota)
            totalRegalia = 0;
            $('[id^="LEY_"]').each(function () {
                const idMineral = $(this).attr('id').replace('LEY_', '');
                const ley = parseFloat($(this).val()) || 0;
                const conversion = parseFloat($(`#CONVERSION_${idMineral}`).val()) || 0;
                const fraccion = parseFloat($(`#FRACCION_${idMineral}`).val()) || 1;
                const alicuota = parseFloat($(`#ALICUOTA_${idMineral}`).val()) || 0;
                const cotizacion = parseFloat($(`#COTIZACION_${idMineral}`).val()) || 0;

                if (ley > 0 && conversion > 0 && cotizacion > 0) {
                    let vbvMineral = ( ( (parseFloat($('#peso_seco').val()) || 0) * (ley / fraccion)) * conversion) * cotizacion * 6.96;
                    let rmMineral = vbvMineral * (alicuota / 100);
                    totalRegalia += rmMineral;
                }
            });
        } else if (tipo === 'porcentaje') {
            // Regalía porcentaje sobre importe total
            const porcentaje = parseFloat($('#porcentaje_regalia').val()) || 0;
            totalRegalia = (importeTotal * porcentaje) / 100;
        }

        $('#regalia_minera').val(totalRegalia.toFixed(2));

        // Recalcular líquido pagable = importe total - deducciones - regalía minera
        const liquidoPagable = importeTotal - totalDeducciones - totalRegalia;
        $('#liquido_pagable').val(liquidoPagable.toFixed(2));
    }

    </script>
@stop