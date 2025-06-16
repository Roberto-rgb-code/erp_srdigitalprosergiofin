<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Evidencias - {{ $vehiculo->placa }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h2>Evidencias - {{ $vehiculo->placa }}</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Relacionado a uso</th>
                <th>Archivo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evidencias as $e)
                <tr>
                    <td>{{ $e->fecha }}</td>
                    <td>{{ $e->tipo }}</td>
                    <td>@if($e->uso) Uso #{{ $e->uso->id }} @else - @endif</td>
                    <td>{{ $e->archivo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
