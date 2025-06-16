<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cuentas por Cobrar</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px;}
        th, td { border: 1px solid #ccc; padding: 4px 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Cuentas por Cobrar</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Saldo</th>
                <th>Fecha vencimiento</th>
                <th>Estatus</th>
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cxc)
                <tr>
                    <td>{{ $cxc->id }}</td>
                    <td>{{ $cxc->cliente->nombre ?? '' }}</td>
                    <td>${{ number_format($cxc->monto, 2) }}</td>
                    <td>${{ number_format($cxc->saldo, 2) }}</td>
                    <td>{{ $cxc->fecha_vencimiento }}</td>
                    <td>{{ $cxc->estatus }}</td>
                    <td>{{ $cxc->comentarios }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
