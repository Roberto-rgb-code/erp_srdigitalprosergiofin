@extends('layouts.app')
@section('content')
<h2>Detalle de Póliza de Servicio</h2>
<table class="table">
    <tr><th>ID</th><td>{{ $polizas_servicio->id }}</td></tr>
    <tr><th>Cliente</th><td>{{ $polizas_servicio->cliente->nombre ?? '' }}</td></tr>
    <tr><th>Tipo</th><td>{{ $polizas_servicio->tipo }}</td></tr>
    <tr><th>Servicios Remotos</th><td>{{ $polizas_servicio->servicios_remotos_restantes }}/{{ $polizas_servicio->servicios_remotos }}</td></tr>
    <tr><th>Servicios Domicilio</th><td>{{ $polizas_servicio->servicios_domicilio_restantes }}/{{ $polizas_servicio->servicios_domicilio }}</td></tr>
    <tr><th>Fecha inicio</th><td>{{ $polizas_servicio->fecha_inicio }}</td></tr>
    <tr><th>Fecha fin</th><td>{{ $polizas_servicio->fecha_fin }}</td></tr>
    <tr><th>Estado</th><td>{{ $polizas_servicio->estatus }}</td></tr>
</table>
<a href="{{ route('polizas_servicio.edit', $polizas_servicio) }}" class="btn btn-warning">Editar</a>
<a href="{{ route('polizas_servicio.index') }}" class="btn btn-secondary">Volver</a>
@endsection
