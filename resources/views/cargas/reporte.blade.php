<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Carga #{{ $carga->lote }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Reporte de Carga #{{ $carga->id }}</h1>

    <table>
        <tr>
            <th>Lote</th>
            <td>{{ $carga->lote }}</td>
        </tr>
        <tr>
            <th>Producto</th>
            <td>{{ $carga->producto ?? '-' }}</td>
        </tr>
        <tr>
            <th>Fecha Registro</th>
            <td>{{ $carga->fecha_registro->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Peso Bruto</th>
            <td>{{ $carga->peso_bruto }} kg</td>
        </tr>
        <tr>
            <th>Peso Tara</th>
            <td>{{ $carga->peso_tara }} kg</td>
        </tr>
        <tr>
            <th>Peso Neto</th>
            <td>{{ $carga->peso_neto }} kg</td>
        </tr>
        <tr>
            <th>Minerales</th>
            <td>
                @foreach($carga->minerales as $mineral)
                    <span style="background-color:#eee; padding:2px 6px; border-radius:4px; margin-right:4px;">
                        {{ $mineral->nombre }}
                    </span>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Estado</th>
            <td>{{ $carga->estado }}</td>
        </tr>
        <tr>
            <th>Tipo</th>
            <td>{{ $carga->tipo }}</td>
        </tr>
    </table>
</body>
</html>