<html>
<head>
    <title>Empleados</title>
    <style>
        table {width: 100%; border-collapse: collapse;}
        td, th {border:1px solid #444; padding:4px;}
    </style>
</head>
<body>
    <h2>Listado de empleados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Apellido</th><th>Puesto</th>
                <th>Fecha ingreso</th><th>Status</th><th>RFC</th><th>CURP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $e)
            <tr>
                <td>{{ $e->id }}</td>
                <td>{{ $e->nombre }}</td>
                <td>{{ $e->apellido }}</td>
                <td>{{ $e->puesto->nombre ?? '-' }}</td>
                <td>{{ $e->fecha_ingreso }}</td>
                <td>{{ $e->status }}</td>
                <td>{{ $e->rfc }}</td>
                <td>{{ $e->curp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
