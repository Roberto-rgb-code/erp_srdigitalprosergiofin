<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles Venta PDF</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 12px;}
        th, td { border: 1px solid #555; padding: 5px; }
        th { background: #eaeaea; }
    </style>
</head>
<body>
    <h2>Detalle de Venta #{{ $venta_id }}</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto/Servicio</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->producto_servicio }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td>${{ number_format($d->precio_unitario,2) }}</td>
                    <td>${{ number_format($d->subtotal,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
