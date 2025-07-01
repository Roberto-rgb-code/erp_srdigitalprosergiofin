@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('recursos_humanos.index') }}" class="btn btn-secondary mb-3">Regresar</a>
    <h2 class="mb-4">Detalle de Empleado</h2>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Columna 1 -->
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><th>ID:</th><td>{{ $empleado->id }}</td></tr>
                        <tr><th>Número de empleado:</th><td>{{ $empleado->numero_empleado }}</td></tr>
                        <tr><th>Nombre:</th><td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td></tr>
                        <tr><th>Puesto:</th><td>{{ $empleado->puesto->nombre ?? '-' }}</td></tr>
                        <tr><th>Fecha de ingreso:</th><td>{{ $empleado->fecha_ingreso ? \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') : '-' }}</td></tr>
                        <tr><th>Status:</th><td>{{ $empleado->status }}</td></tr>
                        <tr><th>Tipo de contrato:</th><td>{{ ucfirst($empleado->tipo_contrato) }}</td></tr>
                        <tr><th>RFC:</th><td>{{ $empleado->rfc }}</td></tr>
                        <tr><th>CURP:</th><td>{{ $empleado->curp }}</td></tr>
                        <tr><th>Edad:</th><td>{{ $empleado->edad ?? '-' }}</td></tr>
                        <tr><th>Sexo:</th><td>{{ $empleado->sexo ?? '-' }}</td></tr>
                        <tr><th>Tipo de sangre:</th><td>{{ $empleado->tipo_sangre ?? '-' }}</td></tr>
                        <tr><th>Fecha de nacimiento:</th><td>{{ $empleado->fecha_nacimiento ? \Carbon\Carbon::parse($empleado->fecha_nacimiento)->format('d/m/Y') : '-' }}</td></tr>
                        <tr><th>Sucursal:</th><td>{{ $empleado->sucursal ?? '-' }}</td></tr>
                    </table>
                </div>
                <!-- Columna 2 -->
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><th>Teléfono:</th><td>{{ $empleado->telefono ?? '-' }}</td></tr>
                        <tr><th>Correo:</th><td>{{ $empleado->correo ?? '-' }}</td></tr>
                        <tr><th>Domicilio:</th><td>{{ $empleado->domicilio ?? '-' }}</td></tr>
                        <tr><th>Estado civil:</th><td>{{ $empleado->estado_civil ?? '-' }}</td></tr>
                        <tr><th>NSS:</th><td>{{ $empleado->nss }}</td></tr>
                        <tr><th>Salario:</th><td>{{ $empleado->salario ? '$'.number_format($empleado->salario,2) : '-' }}</td></tr>
                        <tr><th>Salario diario fiscal:</th><td>{{ $empleado->salario_diario_fiscal ? '$'.number_format($empleado->salario_diario_fiscal,2) : '-' }}</td></tr>
                        <tr><th>Salario diario no fiscal:</th><td>{{ $empleado->salario_diario_no_fiscal ? '$'.number_format($empleado->salario_diario_no_fiscal,2) : '-' }}</td></tr>
                        <tr><th>Salario mensual fiscal:</th><td>{{ $empleado->salario_mensual_fiscal ? '$'.number_format($empleado->salario_mensual_fiscal,2) : '-' }}</td></tr>
                        <tr><th>Salario mensual no fiscal:</th><td>{{ $empleado->salario_mensual_no_fiscal ? '$'.number_format($empleado->salario_mensual_no_fiscal,2) : '-' }}</td></tr>
                        <tr><th>Horario:</th><td>{{ $empleado->horario ?? '-' }}</td></tr>
                        <tr><th>Días laborales:</th><td>{{ $empleado->dias_laborales ?? '-' }}</td></tr>
                        <tr><th>Tipo de empleado:</th><td>{{ ucfirst($empleado->tipo_empleado) }}</td></tr>
                    </table>
                </div>
            </div>
            <!-- Contacto emergencia -->
            <h5 class="mt-4">Contacto de Emergencia</h5>
            <table class="table table-borderless">
                <tr><th>Nombre:</th><td>{{ $empleado->contacto_emergencia ?? '-' }}</td></tr>
                <tr><th>Parentesco:</th><td>{{ $empleado->parentesco ?? '-' }}</td></tr>
                <tr><th>Teléfono:</th><td>{{ $empleado->telefono_beneficiario ?? '-' }}</td></tr>
            </table>
            <!-- Datos bancarios -->
            <h5 class="mt-4">Datos Bancarios</h5>
            <table class="table table-borderless">
                <tr><th>Cuenta fiscal:</th><td>{{ $empleado->cuenta_fiscal ?? '-' }}</td></tr>
                <tr><th>CLABE fiscal:</th><td>{{ $empleado->clabe_fiscal ?? '-' }}</td></tr>
                <tr><th>Banco fiscal:</th><td>{{ $empleado->banco_fiscal ?? '-' }}</td></tr>
                <tr><th>Cuenta no fiscal:</th><td>{{ $empleado->cuenta_no_fiscal ?? '-' }}</td></tr>
                <tr><th>CLABE no fiscal:</th><td>{{ $empleado->clabe_no_fiscal ?? '-' }}</td></tr>
                <tr><th>Banco no fiscal:</th><td>{{ $empleado->banco_no_fiscal ?? '-' }}</td></tr>
            </table>
            <!-- Justificantes -->
            @if($empleado->justificantes_incapacidad)
                <h5 class="mt-4">Justificantes de incapacidad</h5>
                <a href="{{ asset('storage/'.$empleado->justificantes_incapacidad) }}" target="_blank" class="btn btn-outline-info btn-sm">Ver archivo</a>
            @endif
            <!-- Notas internas -->
            <div class="mt-3">
                <h6>Notas internas:</h6>
                <div class="border rounded p-2 bg-light">{{ $empleado->notas ?? '-' }}</div>
            </div>
            <div class="mt-4">
                <a href="{{ route('recursos_humanos.edit', $empleado) }}" class="btn btn-warning">Editar</a>
            </div>
        </div>
    </div>
    {{-- Submódulos --}}
    <div class="mt-4">
        <a href="{{ route('recursos_humanos.nominas.index',$empleado) }}" class="btn btn-outline-info btn-sm me-2">Nómina</a>
        <a href="{{ route('recursos_humanos.permisos.index',$empleado) }}" class="btn btn-outline-primary btn-sm me-2">Permisos</a>
        <a href="{{ route('recursos_humanos.asistencias.index',$empleado) }}" class="btn btn-outline-warning btn-sm me-2">Asistencias</a>
        <a href="{{ route('recursos_humanos.documentos.index',$empleado) }}" class="btn btn-outline-success btn-sm">Documentos</a>
    </div>
</div>
@endsection
