@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle Usuario (Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b>)</h2>
    <div class="card p-4 shadow">
        <div><strong>ID:</strong> {{ $usuario->id }}</div>
        <div><strong>Cliente:</strong> {{ $usuario->cliente->nombre ?? '' }}</div>
        <div><strong>Nombre:</strong> {{ $usuario->nombre }}</div>
        <div><strong>Rol:</strong> {{ $usuario->rol }}</div>
        <div><strong>Usuario:</strong> {{ $usuario->usuario }}</div>
        <div><strong>Fecha alta:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</div>
        <div>
            <a href="{{ route('servicios_empresariales.usuarios_clientes.index', $servicio->id) }}" class="btn btn-secondary mt-3">Regresar</a>
        </div>
    </div>
</div>
@endsection
