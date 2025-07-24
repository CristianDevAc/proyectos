@extends('adminlte::page')

@section('title', 'Dashboard Minerales')

@section('content_header')
    <h1>Gráficos de Cotizaciones de Minerales</h1>
@stop

@section('content')

    <form method="GET" class="form-inline mb-3">
        <select name="filtro" class="form-control mr-2">
            <option value="ANIO" {{ $filtro == 'ANIO' ? 'selected' : '' }}>Por Año</option>
            <option value="MES" {{ $filtro == 'MES' ? 'selected' : '' }}>Por Mes</option>
            <option value="QUINCENA" {{ $filtro == 'QUINCENA' ? 'selected' : '' }}>Por Quincena</option>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <div>
        <canvas id="graficoMinerales"></canvas>
    </div>
    <!-- Modal HTML -->
    <!-- Modal -->
    <div class="modal fade" id="cotizacionesModal" tabindex="-1" role="dialog" aria-labelledby="cotizacionesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="cotizacionesModalLabel">
                        Cotizaciones actuales ({{ strtoupper($quincena) }} Quincena - {{ $mes }}/{{ $gestion }})
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($hayCotizaciones)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mineral</th>
                                    <th>Valor (USD)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cotizacionesActuales as $cotizacion)
                                    <tr>
                                        <td>{{ $cotizacion->mineral->nombre }}</td>
                                        <td>{{ number_format($cotizacion->valor, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">
                            <strong>No se han registrado cotizaciones</strong> para la {{ strtolower($quincena) }} quincena de {{ $mes }}/{{ $gestion }}.<br>
                            <a href="{{ route('cotizacion.create') }}" class="btn btn-warning mt-2">Registrar cotizaciones ahora</a>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
     $(document).ready(function () {
        $('#cotizacionesModal').modal('show');
    });
    const datos = @json($datos);

    const ctx = document.getElementById('graficoMinerales').getContext('2d');

    const datasets = [];
    let etiquetasGlobales = [];

    Object.keys(datos).forEach(function(mineral) {
        const registros = datos[mineral];

        const valores = registros.map(r => r.valor);

        const etiquetas = registros.map(r => {
            if ("{{ $filtro }}" === 'ANIO') {
                return r.gestion;
            } else if ("{{ $filtro }}" === 'MES') {
                return `${r.gestion}-${String(r.mes).padStart(2, '0')}`;
            } else {
                return `${r.gestion}-${String(r.mes).padStart(2, '0')}-${r.quincena}`;
            }
        });

        etiquetasGlobales = etiquetas;

        datasets.push({
            label: mineral,
            data: valores,
            fill: false,
            borderColor: getRandomColor(),
            tension: 0.1
        });
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: etiquetasGlobales,
            datasets: datasets
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Evolución de Cotizaciones de Minerales'
                }
            }
        }
    });

    function getRandomColor() {
        return 'rgba(' + Math.floor(Math.random() * 255) + ',' +
                        Math.floor(Math.random() * 255) + ',' +
                        Math.floor(Math.random() * 255) + ', 0.8)';
    }
    
</script>
@endsection