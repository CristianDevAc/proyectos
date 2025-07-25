@extends('adminlte::page')

@section('title', 'Registrar Muestra de Laboratorio')

@section('content_header')
    <h1>Registrar Nueva Muestra de Laboratorio</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        Datos de la Muestra
    </div>
    <div class="card-body">
        <form action="{{ route('muestras.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="carga_id">Seleccionar Carga (solo PESAJES) <span class="text-danger">*</span></label>
                <select name="carga_id" id="carga_id" class="form-control select2-cargas @error('carga_id') is-invalid @enderror">
                    <option value="">Seleccione una carga...</option>
                    @foreach($cargas as $carga)
                        @php $proveedor = $carga->personas->first(); @endphp
                        <option value="{{ $carga->id }}" {{ old('carga_id') == $carga->id ? 'selected' : '' }}>
                            Lote: {{ $carga->lote }} -
                            Cliente: {{ $proveedor->nombre_completo ?? 'N/A' }} -
                            CI: {{ $proveedor->documento ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>

                @error('carga_id')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="laboratorio_id">Laboratorio <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="laboratorio_id" id="laboratorio_id" class="form-control select2-laboratorio @error('laboratorio_id') is-invalid @enderror">
                                <option value="">Seleccione un laboratorio...</option>
                                @foreach ($laboratorios as $laboratorio)
                                    <option value="{{ $laboratorio->id }}" {{ old('laboratorio_id') == $laboratorio->id ? 'selected' : '' }}>
                                        {{ $laboratorio->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalLaboratorio">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                            @error('laboratorio_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="fecha_muestra">Fecha de Muestra <span class="text-danger">*</span></label>
                        <input type="date" 
                            name="fecha_muestra" 
                            id="fecha_muestra"
                            value="{{ old('fecha_muestra') }}" 
                            class="form-control @error('fecha_muestra') is-invalid @enderror"
                            required>

                        @error('fecha_muestra')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="tipo">Tipo de Muestra</label>
                        <select name="tipo" class="form-control">
                            <option value="NORMAL">NORMAL</option>
                            <option value="CERTIFICADO">CERTIFICADO</option>
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <label class="font-weight-bold mb-2">Certificado / Laboratorio <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imagen_certificado" name="imagen_certificado" accept="image/*">
                                <label class="custom-file-label" for="imagen_certificado">Seleccionar archivo</label>
                            </div>
                            <small class="form-text text-muted">Solo imágenes (jpg, png). Máximo 5MB.</small>
                        </div>

                        <div id="preview-container" style="display:none; margin-left: 20px;">
                            <label class="small">Vista previa:</label>
                            <img id="preview-imagen" src="#" alt="Vista previa" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px;">
                        </div>
                    </div>
                </div>
            </div>
            <div id="minerales-container">
                <!-- Aquí se llenarán dinámicamente los campos de ley y humedad -->
            </div>
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3"></textarea>
            </div>
            

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Generar Muestra
            </button>
            <a href="{{ route('muestras.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </form>
    </div>
</div>
<!-- Modal para agregar Laboratorio -->
<div class="modal fade" id="modalLaboratorio" tabindex="-1" role="dialog" aria-labelledby="modalLaboratorioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formLaboratorio">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLaboratorioLabel">Registrar Laboratorio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del Laboratorio</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Responsable</label>
                        <input type="text" name="responsable" id="responsable" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" >
                    </div>
                    <div id="laboratorioErrors" class="alert alert-danger d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Laboratorio</button>
                </div>
            </div>
        </form>
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
    document.getElementById('imagen_certificado').addEventListener('change', function(event){
        const input = event.target;
        const file = input.files[0];
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-imagen');
        const label = input.nextElementSibling;

        if(file) {
            // Actualiza el label con el nombre del archivo
            label.textContent = file.name;

            // Mostrar vista previa
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            // Si no hay archivo seleccionado
            label.textContent = "Seleccionar archivo";
            previewContainer.style.display = 'none';
            previewImage.src = '#';
        }
    });
    $(document).ready(function () {
        $('.select2-cargas').select2({
            placeholder: 'Buscar carga por lote o producto...',
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
         $('#formLaboratorio').submit(function(e) {
            e.preventDefault();

            let formData = {
                nombre: $('#nombre').val(),
                responsable: $('#responsable').val(),
                telefono: $('#telefono').val(),
                direccion: $('#direccion').val(),
                _token: $('input[name="_token"]').val(),
            };

            // Limpiar errores previos
            $('#laboratorioErrors').addClass('d-none').empty();

            $.ajax({
                url: "{{ route('laboratorios.store') }}",  // Ruta para guardar laboratorio vía ajax
                method: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        // Crear nueva opción y agregarla al select2
                        let newOption = new Option(response.laboratorio.nombre, response.laboratorio.id, true, true);
                        $('#laboratorio_id').append(newOption).trigger('change');

                        // Cerrar modal y resetear formulario
                        $('#modalLaboratorio').modal('hide');
                        $('#formLaboratorio')[0].reset();
                    } else {
                        $('#laboratorioErrors').removeClass('d-none').text(response.message || 'Error al guardar el laboratorio');
                    }
                },
                error: function(xhr) {
                    if(xhr.status === 422) { // Error de validación
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = '<ul>';
                        $.each(errors, function(key, messages) {
                            messages.forEach(msg => {
                                errorHtml += `<li>${msg}</li>`;
                            });
                        });
                        errorHtml += '</ul>';
                        $('#laboratorioErrors').removeClass('d-none').html(errorHtml);
                    } else {
                        $('#laboratorioErrors').removeClass('d-none').text('Error inesperado');
                    }
                }
            });
        });
        $('#carga_id').on('change', function () {
            const cargaId = $(this).val();
            if (!cargaId) {
                $('#minerales-container').empty();
                return;
            }

            // Petición AJAX para obtener los minerales de la carga seleccionada
            $.ajax({
                url: `/api/cargas/${cargaId}/minerales`,
                method: 'GET',
                success: function (data) {
                    let html = '';

                    if (data.length === 0) {
                        html = '<div class="alert alert-warning">Esta carga no tiene minerales asociados.</div>';
                    } else {
                        html += '<h5>Datos de minerales</h5>';
                        data.forEach(function (mineral, index) {
                            html += `
                                <div class="card card-primary card-outline mb-3 shadow-sm">
                                    <div class="card-header py-2">
                                        <h3 class="card-title text-sm mb-0">
                                            <i class="fas fa-flask mr-1"></i> Mineral: ${mineral.nombre}
                                        </h3>
                                    </div>
                                    <div class="card-body py-2">
                                        <input type="hidden" name="minerales[${index}][mineral_id]" value="${mineral.id}">

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group mb-1">
                                                    <label class="mb-1">Ley (%)</label>
                                                    <input type="number" step="0.01" min="0" max="100" 
                                                        class="form-control form-control-sm"
                                                        name="minerales[${index}][ley]" required
                                                        placeholder="Ej. 45.50">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-1">
                                                    <label class="mb-1">Humedad (%)</label>
                                                    <input type="number" step="0.01" min="0" max="100" 
                                                        class="form-control form-control-sm"
                                                        name="minerales[${index}][humedad]" required
                                                        placeholder="Ej. 10.00">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    }

                    $('#minerales-container').html(html);
                },
                error: function () {
                    $('#minerales-container').html('<div class="alert alert-danger">No se pudieron cargar los minerales.</div>');
                }
            });
        });
    });
    $('form').submit(function(e) {
        if ($('#minerales-container').is(':empty')) {
            alert('Debe seleccionar una carga válida para ingresar datos de minerales.');
            e.preventDefault();
            return false;
        }
    });
</script>
@endsection