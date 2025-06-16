<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Servicios Empresariales</title>
    <style>table {width:100%;border-collapse:collapse;} th,td{border:1px solid #222;padding:4px;}</style>
</head>
<body>
<h2>Servicios Empresariales</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Póliza</th>
            <th>Estatus</th>
            <th>Comentarios</th>
        </tr>
    </thead>
    <tbody>
        @foreach($servicios as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->cliente->nombre ?? '-' }}</td>
            <td>{{ $s->poliza->tipo ?? '-' }}</td>
            <td>{{ $s->estatus }}</td>
            <td>{{ $s->comentarios }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
