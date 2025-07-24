<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Liquidación PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10.5px;
            color: #222;
            margin: 5px 10px 10px 10px;
        }

        h3, h4 {
            text-align: center;
            margin: 2px 0 6px 0;
            font-weight: 700;
            letter-spacing: 1px;
            color: #0a3d62;
            font-size: 13px;
        }

        small {
            display: block;
            text-align: center;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4b4b4b;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 3px 5px;
            vertical-align: middle;
            font-weight: 500;
            font-size: 10px;
        }

        th {
            background-color: #d1d8e0;
            color: #2d3436;
            font-weight: 600;
            text-align: left;
            white-space: nowrap;
        }

        td {
            font-weight: 400;
        }

        .label {
            width: 150px;
            background-color: #e0e5ec;
            white-space: nowrap;
            font-weight: 600;
        }

        .nowrap {
            white-space: nowrap;
        }

        .inline-block {
            display: inline-block;
            margin-bottom: 1px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .section-header {
            background-color: #576574;
            color: #fff;
            font-weight: 700;
            padding: 4px 6px;
            margin-bottom: 4px;
            text-align: center;
            border-radius: 3px;
            font-size: 11px;
        }

        /* Contenedor de Contribuciones y Totales sin bordes */
        .tabla-contenedora {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .tabla-contenedora td {
            border: none;
            vertical-align: top;
            padding: 0 8px;
            width: 50%;
        }

        .tabla-contenedora td:first-child {
            padding-left: 0;
        }

        .tabla-contenedora td:last-child {
            padding-right: 0;
        }

        .tabla-interna th,
        .tabla-interna td {
            padding: 2px 4px;
            font-size: 9.5px;
        }

        /* Firma */
        .firmas {
            width: 100%;
            margin-top: 25px;
            text-align: center;
            border: none;
        }

        .firmas td {
            width: 33%;
            padding-top: 40px;
        }

        /* Resaltar líquido pagable */
        .highlight {
            font-weight: 700;
            font-size: 11px;
            color: #1e3799;
        }

        .no-top-margin {
            margin-top: 0 !important;
        }
    </style>
</head>
<body>

    <h3 class="no-top-margin">LIQUIDACIÓN DE MINERALES</h3>
    <small>EXPRESADO EN BOLIVIANOS</small>

    <table>
        <tr>
            <th class="label">Nombre del Proveedor</th>
            <td>{{ optional($liquidacion->carga->personas->firstWhere('pivot.tipo', 'PROVEEDOR'))->nombre_completo ?? 'N/A' }}</td>
            <th class="label">Fecha Entrega</th>
            <td class="nowrap">{{ $liquidacion->carga->fecha_registro->format('d/m/Y') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th class="label">Mina y/o Concesión</th>
            <td>{{ $liquidacion->carga->concesionMina->mina ?? 'N/A' }}</td>
            <th class="label">Cooperativa Minera</th>
            <td>{{ $liquidacion->carga->cooperativa->nombre ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th class="label">T/C USC</th>
            <td>{{ number_format($liquidacion->cotizacion_dolar, 2) ?? 'N/A' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th class="label">Cotización Oficial</th>
            <td colspan="3">
                @forelse($cotizaciones as $item)
                    <div class="inline-block">
                        <strong>{{ $item['mineral']->nombre }}</strong> ({{ $item['alicuota'] }}%) — 
                        Cotización: <strong>{{ $item['cotizacion'] }}</strong>
                    </div>
                @empty
                    <span class="text-muted">No hay minerales registrados.</span>
                @endforelse
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <th class="label">Nro Lote</th>
            <td>{{ $liquidacion->carga->lote ?? 'N/A' }}</td>
            <th class="label">P.N.H (kg)</th>
            <td class="text-right">{{ number_format($liquidacion->peso_humedo, 2) }}</td>
        </tr>
        <tr>
            <th class="label">P.N.S (kg)</th>
            <td class="text-right">{{ number_format($liquidacion->peso_seco, 2) }}</td>
            <th class="label">Valor Bruto Compra</th>
            <td class="text-right">Bs {{ number_format($liquidacion->valor_bruto_compra, 2) }}</td>
        </tr>
        <tr>
            <th class="label">Precio/Kilo</th>
            <td class="text-right">Bs {{ number_format($liquidacion->valor_tonelada_bs, 2) }}</td>
            <th class="label">Importe</th>
            <td class="text-right">Bs {{ number_format($liquidacion->importe_total, 2) }}</td>
        </tr>
        <tr>
            <th class="label">Leyes</th>
            <td colspan="3">
                @forelse($liquidacion->minerales as $mineral)
                    <div class="inline-block">
                        <strong>{{ $mineral->nombre }}</strong>: {{ number_format($mineral->pivot->ley, 2) }}%
                    </div>
                @empty
                    <span class="text-muted">No registradas</span>
                @endforelse
            </td>
        </tr>
    </table>

    <!-- Tabla contenedora de Contribuciones y Totales -->
    <table class="tabla-contenedora">
        <tr>
            <td>
                <div class="section-header">Contribuciones</div>
                <table class="tabla-interna">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="text-center">%</th>
                            <th class="text-right">Monto (Bs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($liquidacion->contribuciones as $contribucion)
                            @php
                                $porcentaje = $contribucion->pivot->porcentaje ?? 0;
                                $monto = ($porcentaje * $liquidacion->importe_total) / 100;
                            @endphp
                            <tr>
                                <td>{{ $contribucion->nombre }}</td>
                                <td class="text-center">{{ $porcentaje }}%</td>
                                <td class="text-right">Bs {{ number_format($monto, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td>
                <div class="section-header">Totales</div>
                <table class="tabla-interna">
                    <tbody>
                        <tr>
                            <th>Total Deducciones</th>
                            <td class="text-right">Bs {{ number_format($liquidacion->total_deducciones, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Total Regalía</th>
                            <td class="text-right">Bs {{ number_format($liquidacion->total_regalia, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Líquido Pagable</th>
                            <td class="text-right highlight">
                                Bs {{ number_format($liquidacion->liquido_pagable, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- Fila final para firmas -->
    <table class="firmas" style="width: 100%; text-align: center; border: none; margin-top: 0px;">
        <tr>
            <td style="width: 33%; border: none; padding: 22px 0;">
                ___________________________<br>
                <strong>ELABORADO POR</strong>
            </td>
            <td style="width: 33%; border: none; padding: 22px 0;">
                ___________________________<br>
                <strong>PAGADO POR</strong>
            </td>
            <td style="width: 33%; border: none; padding: 22px 0;">
                ___________________________<br>
                <strong>INTERESADO</strong>
            </td>
        </tr>
    </table>

</body>
</html>