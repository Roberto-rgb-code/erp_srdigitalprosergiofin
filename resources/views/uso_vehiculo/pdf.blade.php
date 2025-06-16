<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bitácora de Uso - {{ $vehiculo->placa }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h2>Bitácora de Uso - {{ $vehiculo->placa }}</h2>
    <table>
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Fecha salida</th>
                <th>Hora salida</th>
                <th>Destino</th>
                <th>Motivo</th>
                <th>Fecha retorno</th>
                <th>Hora retorno</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usos as $u)
                <tr>
                    <td>{{ $u->empleado->nombre ?? '-' }}</td>
                    <td>{{ $u->fecha_salida }}</td>
                    <td>{{ $u->hora_salida }}</td>
                    <td>{{ $u->destino }}</td>
                    <td>{{ $u->motivo }}</td>
                    <td>{{ $u->fecha_retorno }}</td>
                    <td>{{ $u->hora_retorno }}</td>
                    <td>{{ $u->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
