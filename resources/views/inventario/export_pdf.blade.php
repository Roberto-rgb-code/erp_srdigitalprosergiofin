<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #444; padding: 4px 6px; vertical-align: top; }
        th { background: #e7f1ff; }
        h2 { text-align: center; margin-bottom: 12px; }
        .serie-list { font-size: 11px; color: #444; }
    </style>
</head>
<body>
    <h2>Inventario de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Proveedor</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>SKU</th>
                <th>No. Serie</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Precio Venta</th>
                <th>Precio Mayoreo</th>
                <th>Costo Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
            <tr>
                <td>{{ $p->folio ?? $p->id }}</td>
                <td>{{ $p->proveedor ? $p->proveedor->nombre : 'Sin proveedor' }}</td>
                <td>{{ $p->tipo_producto }}</td>
                <td>{{ $p->producto }}</td>
                <td>{{ $p->sku }}</td>
                <td>
                    @if($p->stockUnits && $p->stockUnits->count())
                        <span class="serie-list">
                        @foreach($p->stockUnits as $su)
                            {{ $su->numero_serie }}<br>
                        @endforeach
                        </span>
                    @else
                        -
                    @endif
                </td>
                <td class="text-end">{{ $p->cantidad }}</td>
                <td class="text-end">${{ number_format($p->costo_unitario,2) }}</td>
                <td class="text-end">${{ number_format($p->precio_venta,2) }}</td>
                <td class="text-end">${{ number_format($p->precio_mayoreo,2) }}</td>
                <td class="text-end">${{ number_format($p->costo_total,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
