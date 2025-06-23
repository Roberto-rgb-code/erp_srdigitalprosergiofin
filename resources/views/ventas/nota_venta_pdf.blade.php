{{-- resources/views/ventas/nota_venta_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Venta #{{ $venta->folio ?? $venta->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; font-size: 13px; }
        .title { font-size: 1.6em; font-weight: bold; text-align: center; margin-bottom: 10px; }
        .datos { margin-bottom: 18px; }
        .datos th { text-align: left; padding-right: 8px; }
        .tabla-productos { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .tabla-productos th, .tabla-productos td { border: 1px solid #aaa; padding: 6px; text-align: left; }
        .tabla-productos th { background: #e7f1ff; }
        .totales { text-align: right; font-size: 1.1em; margin-top: 10px; }
        .section-title { font-weight: bold; margin-top: 20px; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="title">Nota de Venta</div>

    <div class="section-title">Datos de la Venta</div>
    <table class="datos">
        <tr>
            <th>Folio:</th>
            <td>{{ $venta->folio ?? $venta->id }}</td>
            <th>Fecha:</th>
            <td>{{ $venta->fecha_venta }}</td>
        </tr>
        <tr>
            <th>Monto Total:</th>
            <td><b>${{ number_format($venta->monto_total,2) }}</b></td>
            <th>Método de Pago:</th>
            <td>{{ $venta->tipo_venta ?? '-' }}</td>
        </tr>
        <tr>
            <th>Estatus:</th>
            <td>{{ $venta->estatus ?? '-' }}</td>
            <th>Comentarios:</th>
            <td>{{ $venta->comentarios ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Datos del Cliente</div>
    <table class="datos">
        <tr>
            <th>Nombre:</th>
            <td>{{ $venta->cliente->nombre ?? '-' }}</td>
            <th>Contacto:</th>
            <td>{{ $venta->cliente->contacto ?? '-' }}</td>
        </tr>
        <tr>
            <th>RFC:</th>
            <td>{{ $venta->cliente->rfc ?? '-' }}</td>
            <th>Dirección:</th>
            <td>{{ $venta->cliente->direccion ?? '-' }}</td>
        </tr>
        @if(isset($venta->cliente->datoFiscal))
            <tr>
                <th>Razón Social:</th>
                <td>{{ $venta->cliente->datoFiscal->razon_social ?? '-' }}</td>
                <th>RFC Fiscal:</th>
                <td>{{ $venta->cliente->datoFiscal->rfc ?? '-' }}</td>
            </tr>
            <tr>
                <th>CP:</th>
                <td>{{ $venta->cliente->datoFiscal->codigo_postal ?? '-' }}</td>
                <th>Uso CFDI:</th>
                <td>{{ $venta->cliente->datoFiscal->uso_cfdi ?? '-' }}</td>
            </tr>
        @endif
    </table>

    <div class="section-title">Productos / Servicios</div>
    <table class="tabla-productos">
        <thead>
            <tr>
                <th>SKU</th>
                <th>No. Serie</th>
                <th>Producto</th>
                <th>Precio Costo</th>
                <th>Precio Venta</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($venta->detalles as $detalle)
            <tr>
                <td>{{ $detalle->sku ?? '-' }}</td>
                <td>{{ $detalle->no_serie ?? '-' }}</td>
                <td>{{ $detalle->nombre_producto ?? '-' }}</td>
                <td>${{ number_format($detalle->precio_costo,2) }}</td>
                <td>${{ number_format($detalle->precio_venta,2) }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>${{ number_format($detalle->subtotal,2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="totales">
        <b>Total: ${{ number_format($venta->monto_total,2) }}</b>
    </div>

    <div class="section-title">¡Gracias por su compra!</div>
</body>
</html>
