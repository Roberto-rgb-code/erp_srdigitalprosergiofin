<!DOCTYPE html>
<html>
<head>
    <title>Clientes PDF</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 4px; }
    </style>
</head>
<body>
    <h2>Listado de Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>RFC</th>
                <th>Dirección</th>
                <th>Contacto</th>
                <th>Tipo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nombre_completo }}</td>
                <td>{{ $cliente->datoFiscal->rfc ?? '-' }}</td>
                <td>{{ $cliente->direccion }}</td>
                <td>{{ $cliente->contacto }}</td>
                <td>{{ $cliente->tipo_cliente }}</td>
                <td>{{ $cliente->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
