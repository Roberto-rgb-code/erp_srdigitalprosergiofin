<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $venta->folio }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px;}
        .factura-box { width: 100%; margin: auto;}
        th, td { border: 1px solid #555; padding: 5px; }
        table { border-collapse: collapse; width: 100%; }
        th { background: #eaeaea; }
    </style>
</head>
<body>
    <h2>Factura: {{ $venta->folio }}</h2>
    <p><b>Cliente:</b> {{ $venta->cliente->nombre }}<br>
       <b>RFC:</b> {{ $venta->cliente->rfc ?? '-' }}<br>
       <b>Fecha de venta:</b> {{ $venta->fecha_venta }}<br>
       <b>Tipo de venta:</b> {{ $venta->tipo_venta ?? '-' }}<br>
    </p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto / Servicio</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $d->producto_servicio }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td>${{ number_format($d->precio_unitario, 2) }}</td>
                    <td>${{ number_format($d->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3 style="text-align: right">TOTAL: ${{ number_format($venta->monto_total, 2) }}</h3>
</body>
</html>
