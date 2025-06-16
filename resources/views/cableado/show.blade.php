@extends('layouts.app')
@section('content')
    <h2>Detalle del Proyecto de Cableado</h2>
    <table class="table">
        <tr><th>ID</th><td>{{ $cableado->id }}</td></tr>
        <tr><th>Nombre del proyecto</th><td>{{ $cableado->nombre_proyecto }}</td></tr>
        <tr><th>Cliente</th><td>{{ $cableado->cliente->nombre ?? '-' }}</td></tr>
        <tr><th>Tipo de instalación</th><td>{{ $cableado->tipo_instalacion }}</td></tr>
        <tr><th>Dirección</th><td>{{ $cableado->direccion }}</td></tr>
        <tr><th>Descripción</th><td>{{ $cableado->descripcion }}</td></tr>
        <tr><th>Fecha de inicio</th><td>{{ $cableado->fecha_inicio }}</td></tr>
        <tr><th>Fecha de fin</th><td>{{ $cableado->fecha_fin }}</td></tr>
        <tr><th>Responsable</th><td>{{ $cableado->responsable->nombre ?? '-' }}</td></tr>
        <tr><th>Costo estimado</th><td>${{ number_format($cableado->costo_estimado,2) }}</td></tr>
        <tr><th>Costo real</th><td>${{ number_format($cableado->costo_real,2) }}</td></tr>
        <tr><th>Estado</th><td>{{ $cableado->estatus }}</td></tr>
        <tr><th>Comentarios</th><td>{{ $cableado->comentarios }}</td></tr>
    </table>
    <a href="{{ route('cableado.index') }}" class="btn btn-secondary">Regresar</a>
    <a href="{{ route('cableado.edit', $cableado) }}" class="btn btn-warning">Editar</a>
@endsection
