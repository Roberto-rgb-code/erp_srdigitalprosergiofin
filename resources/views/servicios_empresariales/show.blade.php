@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Servicio Empresarial #{{ $servicio_empresarial->id }}</h1>

    <p><strong>Cliente:</strong> {{ $servicio_empresarial->cliente->nombre_completo ?? 'N/A' }}</p>
    <p><strong>Tipo de Póliza:</strong> {{ $servicio_empresarial->tipo_poliza }}</p>
    <p><strong>Estatus:</strong> {{ $servicio_empresarial->estatus }}</p>
    <p><strong>Fecha de Inicio:</strong> {{ $servicio_empresarial->fecha_inicio->format('d/m/Y') }}</p>
    <p><strong>Fecha de Fin:</strong> {{ $servicio_empresarial->fecha_fin ? $servicio_empresarial->fecha_fin->format('d/m/Y') : '-' }}</p>
    <p><strong>Comentarios:</strong></p>
    <p>{{ $servicio_empresarial->comentarios ?? 'Sin comentarios' }}</p>

    <a href="{{ route('servicios_empresariales.edit', $servicio_empresarial) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
