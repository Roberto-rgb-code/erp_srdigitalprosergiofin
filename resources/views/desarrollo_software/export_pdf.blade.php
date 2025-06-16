<!DOCTYPE html>
<html>
<head>
    <title>Proyectos de Software</title>
    <style>
        table {width:100%;border-collapse:collapse;}
        th,td {border:1px solid #888;padding:4px;}
    </style>
</head>
<body>
<h2>Proyectos de Desarrollo de Software</h2>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Responsable</th>
            <th>Estado</th>
            <th>Inicio</th>
            <th>Entrega</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proyectos as $p)
        <tr>
            <td>{{ $p->nombre }}</td>
            <td>{{ $p->cliente->nombre ?? '-' }}</td>
            <td>{{ $p->tipoSoftware->nombre ?? '-' }}</td>
            <td>{{ $p->responsable->nombre ?? '-' }}</td>
            <td>{{ $p->estado }}</td>
            <td>{{ $p->fecha_inicio }}</td>
            <td>{{ $p->fecha_fin }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
