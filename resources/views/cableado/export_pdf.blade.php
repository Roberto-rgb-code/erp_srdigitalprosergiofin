<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyectos de Cableado PDF</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 11px;}
        th, td { border: 1px solid #555; padding: 4px; }
        th { background: #eaeaea; }
    </style>
</head>
<body>
    <h2>Proyectos de Cableado</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Proyecto</th>
                <th>Cliente</th>
                <th>Tipo instalación</th>
                <th>Dirección</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Costo estimado</th>
                <th>Costo real</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cableados as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre_proyecto }}</td>
                    <td>{{ $c->cliente->nombre ?? '-' }}</td>
                    <td>{{ $c->tipo_instalacion }}</td>
                    <td>{{ $c->direccion }}</td>
                    <td>{{ $c->fecha_inicio }}</td>
                    <td>{{ $c->fecha_fin }}</td>
                    <td>{{ $c->responsable->nombre ?? '-' }}</td>
                    <td>{{ $c->estatus }}</td>
                    <td>${{ number_format($c->costo_estimado,2) }}</td>
                    <td>${{ number_format($c->costo_real,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
