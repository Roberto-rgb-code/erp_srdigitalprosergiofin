<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consumo de Combustible - {{ $vehiculo->placa }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h2>Consumo de Combustible - {{ $vehiculo->placa }}</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Litros</th>
                <th>Monto</th>
                <th>Ticket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumos as $c)
                <tr>
                    <td>{{ $c->fecha }}</td>
                    <td>{{ $c->litros }}</td>
                    <td>${{ number_format($c->monto,2) }}</td>
                    <td>{{ $c->ticket ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
