<!DOCTYPE html>
<html>
<head>
    <title>Reporte Cuentas por Pagar</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #555; padding: 6px; text-align: left; }
        th { background: #f3f3f3; }
    </style>
</head>
<body>
    <h2>Reporte de Cuentas por Pagar</h2>
    <table>
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Factura</th>
                <th>Monto</th>
                <th>Saldo</th>
                <th>Fecha vencimiento</th>
                <th>Fecha pago</th>
                <th>Estatus</th>
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros as $c)
            <tr>
                <td>{{ $c->proveedor->nombre ?? '' }}</td>
                <td>{{ $c->factura }}</td>
                <td>{{ $c->monto }}</td>
                <td>{{ $c->saldo }}</td>
                <td>{{ $c->fecha_vencimiento }}</td>
                <td>{{ $c->fecha_pago }}</td>
                <td>{{ $c->estatus }}</td>
                <td>{{ $c->comentarios }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
