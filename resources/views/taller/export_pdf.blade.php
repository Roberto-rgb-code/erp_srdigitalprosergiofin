<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes de Servicio PDF</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 11px;}
        th, td { border: 1px solid #555; padding: 4px; }
        th { background: #eaeaea; }
    </style>
</head>
<body>
    <h2>Órdenes de Servicio</h2>
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Equipo</th>
                <th>Ingreso</th>
                <th>Entrega</th>
                <th>Técnico</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($talleres as $t)
                <tr>
                    <td>{{ $t->folio }}</td>
                    <td>{{ $t->cliente->nombre ?? '-' }}</td>
                    <td>
                        {{ $t->equipo->tipo ?? '-' }}
                        {{ $t->equipo->marca ?? '' }}
                        {{ $t->equipo->modelo ?? '' }}
                        ({{ $t->equipo->imei ?? '' }})
                    </td>
                    <td>{{ $t->fecha_ingreso }}</td>
                    <td>{{ $t->fecha_entrega }}</td>
                    <td>{{ $t->tecnico->nombre ?? '-' }}</td>
                    <td>{{ $t->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
