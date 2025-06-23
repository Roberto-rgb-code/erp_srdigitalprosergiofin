@extends('layouts.app')
@section('content')
    <h2>Detalle de Proyecto: {{ $desarrollo_software->nombre }}</h2>
    <table class="table">
        <tr><th>Cliente</th><td>{{ $desarrollo_software->cliente->nombre_completo ?? '-' }}</td></tr>
        <tr><th>Tipo</th><td>{{ $desarrollo_software->tipo_software ?? '-' }}</td></tr>
        <tr><th>Responsable</th><td>{{ $desarrollo_software->responsable->nombre ?? '-' }}</td></tr>
        <tr><th>Estado</th><td>{{ $desarrollo_software->estado }}</td></tr>
        <tr><th>Stack tecnológico</th><td>{{ $desarrollo_software->stack_tecnologico }}</td></tr>
        <tr><th>Fecha inicio</th><td>{{ $desarrollo_software->fecha_inicio }}</td></tr>
        <tr><th>Fecha entrega</th><td>{{ $desarrollo_software->fecha_fin }}</td></tr>
        <tr><th>Historial</th><td>{{ $desarrollo_software->historial }}</td></tr>
    </table>

    <h4>Módulos del sistema</h4>
    <a href="{{ route('modulos_software.index', $desarrollo_software->id) }}" class="btn btn-outline-primary">Ver módulos</a>
    <a href="{{ route('desarrollo_software.index') }}" class="btn btn-secondary">Regresar</a>
@endsection
