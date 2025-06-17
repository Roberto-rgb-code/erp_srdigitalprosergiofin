<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { border: 1px solid #ccc; padding: 6px 8px;}
        th { background: #e6e6e6; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Monto Total</th>
                <th>Estatus</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $v)
            <tr>
                <td>{{ $v->folio }}</td>
                <td>{{ $v->cliente->nombre ?? '-' }}</td>
                <td>{{ $v->fecha_venta }}</td>
                <td>${{ number_format($v->monto_total,2) }}</td>
                <td>{{ $v->estatus }}</td>
                <td>{{ $v->tipo_venta }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
