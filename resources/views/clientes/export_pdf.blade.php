<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes PDF</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 12px;}
        th, td { border: 1px solid #555; padding: 5px; }
        th { background: #eaeaea; }
    </style>
</head>
<body>
    <h2>Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>RFC</th><th>Dirección</th>
                <th>Contacto</th><th>Tipo</th><th>Límite Crédito</th>
                <th>Saldo</th><th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->rfc }}</td>
                    <td>{{ $c->direccion }}</td>
                    <td>{{ $c->contacto }}</td>
                    <td>{{ $c->tipo_cliente }}</td>
                    <td>${{ number_format($c->limite_credito,2) }}</td>
                    <td>${{ number_format($c->saldo,2) }}</td>
                    <td>{{ $c->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
