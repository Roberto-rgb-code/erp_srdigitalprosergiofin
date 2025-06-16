<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mantenimientos - {{ $vehiculo->placa }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h2>Mantenimientos - {{ $vehiculo->placa }}</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo de servicio</th>
                <th>Kilometraje</th>
                <th>Costo</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mantenimientos as $m)
                <tr>
                    <td>{{ $m->fecha }}</td>
                    <td>{{ $m->tipo_servicio }}</td>
                    <td>{{ $m->kilometraje }}</td>
                    <td>${{ number_format($m->costo,2) }}</td>
                    <td>{{ $m->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
