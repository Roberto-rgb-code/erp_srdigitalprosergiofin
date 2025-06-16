@extends('layouts.app')
@section('content')
    <h2>Detalle del Vehículo</h2>
    <table class="table">
        <tr><th>ID</th><td>{{ $vehiculo->id }}</td></tr>
        <tr><th>Placa</th><td>{{ $vehiculo->placa }}</td></tr>
        <tr><th>Marca</th><td>{{ $vehiculo->marca }}</td></tr>
        <tr><th>Modelo</th><td>{{ $vehiculo->modelo }}</td></tr>
        <tr><th>Año</th><td>{{ $vehiculo->año }}</td></tr>
        <tr><th>Tipo</th><td>{{ $vehiculo->tipo }}</td></tr>
        <tr><th>Kilometraje</th><td>{{ $vehiculo->kilometraje ?? 0 }}</td></tr>
        <tr><th>Responsable</th><td>{{ $vehiculo->responsable->nombre ?? '-' }}</td></tr>
        <tr><th>Cliente</th><td>{{ $vehiculo->cliente->nombre ?? '-' }}</td></tr>
        <tr><th>Estado</th><td>{{ $vehiculo->status }}</td></tr>
        <tr><th>Fecha de adquisición</th><td>{{ $vehiculo->fecha_adquisicion }}</td></tr>
    </table>

    <div class="mb-3">
        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">Regresar</a>
        <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="btn btn-warning">Editar</a>
    </div>

    <h4>Submódulos</h4>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('vehiculos.consumo.index', $vehiculo->id) }}" class="btn btn-outline-primary">Consumo de combustible</a>
        <a href="{{ route('vehiculos.mantenimiento.index', $vehiculo->id) }}" class="btn btn-outline-success">Mantenimientos</a>
        <a href="{{ route('vehiculos.uso.index', $vehiculo->id) }}" class="btn btn-outline-info">Bitácora de uso</a>
        <a href="{{ route('vehiculos.evidencia.index', $vehiculo->id) }}" class="btn btn-outline-dark">Evidencias</a>
    </div>
@endsection
