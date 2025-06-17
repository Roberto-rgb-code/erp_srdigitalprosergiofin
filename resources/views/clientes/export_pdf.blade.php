<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Clientes</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px;}
        table { width: 100%; border-collapse: collapse;}
        th, td { border: 1px solid #ccc; padding: 5px;}
        th { background: #f0f0f0;}
    </style>
</head>
<body>
    <h2>Reporte de Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>RFC</th>
                <th>Dirección</th>
                <th>Contacto</th>
                <th>Tipo</th>
                <th>¿Requiere factura?</th>
                <th>Límite crédito</th>
                <th>Saldo</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $c)
                <tr>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->rfc }}</td>
                    <td>{{ $c->direccion }}</td>
                    <td>{{ $c->contacto }}</td>
                    <td>{{ $c->tipo_cliente }}</td>
                    <td>{{ $c->requiere_factura ? 'Sí' : 'No' }}</td>
                    <td>${{ number_format($c->limite_credito,2) }}</td>
                    <td>${{ number_format($c->saldo,2) }}</td>
                    <td>{{ $c->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
