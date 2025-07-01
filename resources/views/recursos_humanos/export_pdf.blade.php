<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleados</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #333;}
        h2 { margin-bottom: 16px;}
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px;}
        th, td { border: 1px solid #444; padding: 5px 7px; }
        th { background: #f2f2f2; }
        .small { font-size: 12px; }
    </style>
</head>
<body>
    <h2>Listado de empleados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Nombre</th>
                <th>Puesto</th>
                <th>Ingreso</th>
                <th>Status</th>
                <th>Tipo Contrato</th>
                <th>Tipo Empleado</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>RFC</th>
                <th>CURP</th>
                <th>NSS</th>
                <th>Salario</th>
                <th>Sal. Diar. Fisc.</th>
                <th>Sal. Diar. No Fisc.</th>
                <th>Sal. Mens. Fisc.</th>
                <th>Sal. Mens. No Fisc.</th>
                <th>Sucursal</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Domicilio</th>
                <th>Estado Civil</th>
                <th>Banco Fiscal</th>
                <th>Cuenta Fiscal</th>
                <th>CLABE Fiscal</th>
                <th>Banco No Fiscal</th>
                <th>Cuenta No Fiscal</th>
                <th>CLABE No Fiscal</th>
                <th>Contacto Emergencia</th>
                <th>Parentesco</th>
                <th>Tel. Beneficiario</th>
                <th>Tipo Sangre</th>
                <th>Notas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $e)
            <tr>
                <td>{{ $e->id }}</td>
                <td>{{ $e->numero_empleado }}</td>
                <td>{{ $e->nombre }} {{ $e->apellido }}</td>
                <td>{{ $e->puesto->nombre ?? '-' }}</td>
                <td>{{ $e->fecha_ingreso ? \Carbon\Carbon::parse($e->fecha_ingreso)->format('d/m/Y') : '-' }}</td>
                <td>{{ $e->status }}</td>
                <td>{{ ucfirst($e->tipo_contrato) }}</td>
                <td>{{ ucfirst($e->tipo_empleado) }}</td>
                <td>{{ $e->edad ?? '-' }}</td>
                <td>{{ $e->sexo ?? '-' }}</td>
                <td>{{ $e->rfc }}</td>
                <td>{{ $e->curp }}</td>
                <td>{{ $e->nss }}</td>
                <td>${{ number_format($e->salario,2) }}</td>
                <td>{{ $e->salario_diario_fiscal ? '$'.number_format($e->salario_diario_fiscal,2) : '-' }}</td>
                <td>{{ $e->salario_diario_no_fiscal ? '$'.number_format($e->salario_diario_no_fiscal,2) : '-' }}</td>
                <td>{{ $e->salario_mensual_fiscal ? '$'.number_format($e->salario_mensual_fiscal,2) : '-' }}</td>
                <td>{{ $e->salario_mensual_no_fiscal ? '$'.number_format($e->salario_mensual_no_fiscal,2) : '-' }}</td>
                <td>{{ $e->sucursal }}</td>
                <td>{{ $e->telefono }}</td>
                <td>{{ $e->correo }}</td>
                <td>{{ $e->domicilio }}</td>
                <td>{{ $e->estado_civil }}</td>
                <td>{{ $e->banco_fiscal }}</td>
                <td>{{ $e->cuenta_fiscal }}</td>
                <td>{{ $e->clabe_fiscal }}</td>
                <td>{{ $e->banco_no_fiscal }}</td>
                <td>{{ $e->cuenta_no_fiscal }}</td>
                <td>{{ $e->clabe_no_fiscal }}</td>
                <td>{{ $e->contacto_emergencia }}</td>
                <td>{{ $e->parentesco }}</td>
                <td>{{ $e->telefono_beneficiario }}</td>
                <td>{{ $e->tipo_sangre }}</td>
                <td class="small">{{ $e->notas }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
