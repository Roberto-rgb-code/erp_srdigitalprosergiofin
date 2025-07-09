{{-- resources/views/ventas/nota_venta_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Venta #{{ $venta->folio ?? $venta->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; font-size: 13px; }
        .title { font-size: 1.7em; font-weight: bold; text-align: center; margin-bottom: 12px; }
        .datos { margin-bottom: 18px; width: 100%; }
        .datos th { text-align: left; padding-right: 10px; font-weight: normal; }
        .datos td { padding-bottom: 2px; }
        .section-title { font-weight: bold; margin-top: 18px; margin-bottom: 8px; }
        .alert-fiscal { background: #e7f1ff; padding: 10px 16px; border-radius: 6px; margin-bottom: 14px;}
        .productos-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .productos-table th, .productos-table td { border: 1px solid #bbb; padding: 5px 7px; }
        .productos-table th { background: #f0f7ff; }
        .text-end { text-align: right; }
        .totales { text-align: right; font-size: 1.13em; margin-top: 12px; }
        .thankyou { text-align:center; margin-top:22px; font-size: 1.1em; font-weight: bold; color: #1976d2; }
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
            <td>{{ $venta->cliente->nombre_completo ?? '-' }}</td>
            <th>Contacto:</th>
            <td>{{ $venta->cliente->contacto ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dirección:</th>
            <td>{{ $venta->cliente->direccion ?? '-' }}</td>
            <th>Tipo de Cliente:</th>
            <td>{{ $venta->cliente->tipo_cliente ?? '-' }}</td>
        </tr>
    </table>

    @php $fiscal = $venta->cliente->datoFiscal ?? null; @endphp
    @if($fiscal)
    <div class="alert-fiscal">
        <b>Datos Fiscales:</b><br>
        <strong>Nombre fiscal:</strong> {{ $fiscal->nombre_fiscal ?? '-' }}<br>
        <strong>RFC:</strong> {{ $fiscal->rfc ?? '-' }}<br>
        <strong>Dirección fiscal:</strong> {{ $fiscal->direccion_fiscal ?? '-' }}<br>
        <strong>Correo:</strong> {{ $fiscal->correo ?? '-' }}<br>
        <strong>Uso CFDI:</strong> {{ $fiscal->uso_cfdi ?? '-' }}<br>
        <strong>Régimen fiscal:</strong> {{ $fiscal->regimen_fiscal ?? '-' }}<br>
    </div>
    @endif

    <div class="section-title">Detalle de productos vendidos</div>
    <table class="productos-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>SKU</th>
                <th class="text-end">Precio unitario</th>
                <th class="text-end">Cantidad</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @php $granTotal = 0; @endphp
        @forelse($venta->productos as $p)
            @php
                $cantidad = $p->pivot->cantidad ?? 0;
                $precio = $p->pivot->precio_unitario ?? $p->precio_venta;
                $subtotal = $cantidad * $precio;
                $granTotal += $subtotal;
            @endphp
            <tr>
                <td>{{ $p->producto }}</td>
                <td>{{ $p->sku }}</td>
                <td class="text-end">${{ number_format($precio, 2) }}</td>
                <td class="text-end">{{ $cantidad }}</td>
                <td class="text-end">${{ number_format($subtotal,2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Sin productos asociados</td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Total</th>
                <th class="text-end">${{ number_format($granTotal, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="totales">
        <b>Total a pagar: ${{ number_format($granTotal,2) }}</b>
    </div>

    <div class="thankyou">¡Gracias por su compra!</div>
</body>
</html>
