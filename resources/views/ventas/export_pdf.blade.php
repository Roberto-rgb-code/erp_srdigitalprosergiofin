<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { border: 1px solid #ccc; padding: 6px 8px; }
        th { background: #e6e6e6; }
        td.text-end { text-align: right; }
        tfoot td { font-weight: bold; background: #fafafa;}
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>RFC</th>
                <th>Fecha</th>
                <th>Monto Total</th>
                <th>Estatus</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @php $granTotal = 0; @endphp
            @foreach($ventas as $v)
            @php $granTotal += $v->monto_total; @endphp
            <tr>
                <td>{{ $v->folio }}</td>
                <td>{{ $v->cliente->nombre_completo ?? '-' }}</td>
                <td>{{ $v->cliente->datoFiscal->rfc ?? '-' }}</td>
                <td>{{ $v->fecha_venta }}</td>
                <td class="text-end">${{ number_format($v->monto_total,2) }}</td>
                <td>{{ $v->estatus }}</td>
                <td>{{ $v->tipo_venta }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end">TOTAL</td>
                <td class="text-end">${{ number_format($granTotal,2) }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    <div style="font-size:11px; color:#888;">
        Generado: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
