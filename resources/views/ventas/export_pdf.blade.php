<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas PDF</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 12px;}
        th, td { border: 1px solid #555; padding: 5px; }
        th { background: #eaeaea; }
    </style>
</head>
<body>
    <h2>Ventas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Cliente</th><th>Fecha</th>
                <th>Monto Total</th><th>Estatus</th><th>Tipo</th><th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->cliente->nombre ?? '' }}</td>
                    <td>{{ $v->fecha_venta }}</td>
                    <td>${{ number_format($v->monto_total,2) }}</td>
                    <td>{{ $v->estatus }}</td>
                    <td>{{ $v->tipo_venta }}</td>
                    <td>{{ $v->comentarios }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
