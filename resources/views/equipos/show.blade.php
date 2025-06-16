@extends('layouts.app')
@section('content')
    <h2>Detalle del Equipo</h2>
    <table class="table">
        <tr><th>ID</th><td>{{ $equipo->id }}</td></tr>
        <tr><th>Tipo</th><td>{{ $equipo->tipo }}</td></tr>
        <tr><th>Marca</th><td>{{ $equipo->marca }}</td></tr>
        <tr><th>Modelo</th><td>{{ $equipo->modelo }}</td></tr>
        <tr><th>Color</th><td>{{ $equipo->color }}</td></tr>
        <tr><th>IMEI / Serie</th><td>{{ $equipo->imei }}</td></tr>
        <tr><th>Condición física</th><td>{{ $equipo->condicion_fisica }}</td></tr>
        <tr><th>Estética</th><td>{{ $equipo->estetica }}</td></tr>
        <tr><th>Tipo de bloqueo</th><td>{{ $equipo->tipo_bloqueo }}</td></tr>
        <tr><th>Zona de trabajo</th><td>{{ $equipo->zona_trabajo }}</td></tr>
    </table>
    <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Regresar</a>
    <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-warning">Editar</a>
@endsection
