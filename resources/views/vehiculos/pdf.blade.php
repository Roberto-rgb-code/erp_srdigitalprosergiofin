<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vehículos</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h2>Vehículos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Placa</th><th>Marca</th><th>Modelo</th><th>Año</th><th>Tipo</th>
                <th>Kilometraje</th><th>Responsable</th><th>Estado</th><th>Fecha adquisición</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehiculos as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->placa }}</td>
                    <td>{{ $v->marca }}</td>
                    <td>{{ $v->modelo }}</td>
                    <td>{{ $v->año }}</td>
                    <td>{{ $v->tipo }}</td>
                    <td>{{ $v->kilometraje }}</td>
                    <td>{{ $v->responsable->nombre ?? '-' }}</td>
                    <td>{{ $v->status }}</td>
                    <td>{{ $v->fecha_adquisicion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
