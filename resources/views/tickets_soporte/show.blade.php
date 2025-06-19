@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle Ticket (Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b>)</h2>
    <div class="card p-4 shadow">
        <div><strong>ID:</strong> {{ $ticket->id }}</div>
        <div><strong>Cliente:</strong> {{ $ticket->cliente->nombre ?? '' }}</div>
        <div><strong>Título:</strong> {{ $ticket->titulo }}</div>
        <div><strong>Descripción:</strong> {{ $ticket->descripcion }}</div>
        <div><strong>Estatus:</strong> {{ $ticket->estatus }}</div>
        <div><strong>Fecha alta:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</div>
        <div>
            <a href="{{ route('servicios_empresariales.tickets_soporte.index', $servicio->id) }}" class="btn btn-secondary mt-3">Regresar</a>
        </div>
    </div>
</div>
@endsection
