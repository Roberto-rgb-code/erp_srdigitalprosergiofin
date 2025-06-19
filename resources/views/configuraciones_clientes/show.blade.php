@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle de Configuración Técnica (Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b>)</h2>
    <div class="card p-4 shadow">
        <div><strong>ID:</strong> {{ $configuracion->id }}</div>
        <div><strong>Cliente:</strong> {{ $configuracion->cliente->nombre ?? '' }}</div>
        <div><strong>Tipo:</strong> {{ $configuracion->tipo }}</div>
        <div><strong>Descripción:</strong> {{ $configuracion->descripcion }}</div>
        <div><strong>Dato:</strong> {{ $configuracion->dato }}</div>
        <div><strong>Fecha alta:</strong> {{ $configuracion->created_at->format('d/m/Y H:i') }}</div>
        <div>
            <a href="{{ route('servicios_empresariales.configuraciones_clientes.index', $servicio->id) }}" class="btn btn-secondary mt-3">Regresar</a>
        </div>
    </div>
</div>
@endsection
