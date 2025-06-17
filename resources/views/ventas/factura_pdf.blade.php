<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Venta - {{ $venta->folio ?? $venta->id }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 14px; margin: 25px;}
        .header { border-bottom: 2px solid #444; margin-bottom: 20px; }
        .header h2 { margin: 0 0 5px 0; }
        .info-table, .products-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .info-table td { padding: 4px 8px; }
        .products-table th, .products-table td { border: 1px solid #ccc; padding: 6px 10px; text-align: center; }
        .products-table th { background: #e9ecef; }
        .totals { text-align: right; font-weight: bold; }
        .footer { border-top: 1px solid #ccc; margin-top: 35px; font-size: 12px; color: #888; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Factura de Venta</h2>
        <div>Folio: <strong>{{ $venta->folio ?? $venta->id }}</strong></div>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Cliente:</strong></td>
            <td>{{ $venta->cliente->nombre ?? '-' }}</td>
            <td><strong>Fecha de venta:</strong></td>
            <td>{{ $venta->fecha_venta }}</td>
        </tr>
        <tr>
            <td><strong>Tipo de venta:</strong></td>
            <td>{{ $venta->tipo_venta ?? '-' }}</td>
            <td><strong>Estatus:</strong></td>
            <td>{{ $venta->estatus ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Monto total:</strong></td>
            <td colspan="3">${{ number_format($venta->monto_total, 2) }}</td>
        </tr>
        @if($venta->comentarios)
        <tr>
            <td><strong>Comentarios:</strong></td>
            <td colspan="3">{{ $venta->comentarios }}</td>
        </tr>
        @endif
    </table>

    <h4>Productos / Servicios</h4>
    <table class="products-table">
        <thead>
            <tr>
                <th>Producto / Servicio</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($venta->detalles as $detalle)
                <tr>
                    <td>
                        {{-- Si el producto existe en catálogo, mostrar su nombre, si no, mostrar el nombre libre --}}
                        {{ $detalle->producto->nombre ?? $detalle->producto_servicio ?? '-' }}
                    </td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->precio_unitario,2) }}</td>
                    <td>${{ number_format($detalle->subtotal,2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="color:gray;">No hay productos o servicios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 10px;">
        <tr>
            <td class="totals" colspan="3">Total:</td>
            <td class="totals">${{ number_format($venta->monto_total, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        Documento generado automáticamente por el sistema ERP &middot; {{ date('d/m/Y H:i') }}
    </div>

</body>
</html>
