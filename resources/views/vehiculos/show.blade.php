@extends('layouts.app')
@section('content')
    <h2>Detalle de Vehículo</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><td>{{ $vehiculo->id }}</td></tr>
        <tr><th>Placa</th><td>{{ $vehiculo->placa }}</td></tr>
        <tr><th>Marca</th><td>{{ $vehiculo->marca }}</td></tr>
        <tr><th>Modelo</th><td>{{ $vehiculo->modelo }}</td></tr>
        <tr><th>Año</th><td>{{ $vehiculo->año }}</td></tr>
        <tr><th>Tipo</th><td>{{ $vehiculo->tipo }}</td></tr>
        <tr><th>Kilometraje</th><td>{{ $vehiculo->kilometraje }}</td></tr>
        <tr><th>Responsable</th><td>{{ $vehiculo->responsable->nombre ?? '-' }}</td></tr>
        {{-- Eliminado Cliente --}}
        <tr><th>Estado</th><td>{{ $vehiculo->status }}</td></tr>
        <tr><th>Fecha de adquisición</th><td>{{ $vehiculo->fecha_adquisicion }}</td></tr>
    </table>
    <div class="mt-3">
        <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
    <div class="mt-4">
        <h4>Submódulos</h4>
        <a href="{{ route('vehiculos.consumo.index', $vehiculo->id) }}" class="btn btn-outline-primary mb-2">Consumo de combustible</a>
        <a href="{{ route('vehiculos.mantenimiento.index', $vehiculo->id) }}" class="btn btn-outline-info mb-2">Mantenimientos</a>
        <a href="{{ route('vehiculos.uso.index', $vehiculo->id) }}" class="btn btn-outline-success mb-2">Bitácora de uso</a>
        <a href="{{ route('vehiculos.evidencia.index', $vehiculo->id) }}" class="btn btn-outline-dark mb-2">Evidencias</a>
    </div>
@endsection
