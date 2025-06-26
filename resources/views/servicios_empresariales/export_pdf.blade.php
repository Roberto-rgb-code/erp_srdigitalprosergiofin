<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Servicios Empresariales</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Listado de Servicios Empresariales</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Póliza</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicios as $servicio)
            <tr>
                <td>{{ $servicio->id }}</td>
                <td>{{ $servicio->cliente->nombre_completo ?? 'N/A' }}</td>
                <td>{{ $servicio->poliza }}</td>
                <td>{{ $servicio->estatus }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
