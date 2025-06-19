@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle Seguimiento de Ticket (Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b>)</h2>
    <div class="card p-4 shadow">
        <div><strong>ID:</strong> {{ $seguimiento->id }}</div>
        <div><strong>Ticket:</strong> {{ $seguimiento->ticket->titulo ?? '' }}</div>
        <div><strong>Cliente:</strong> {{ $seguimiento->cliente->nombre ?? '' }}</div>
        <div><strong>Comentario:</strong> {{ $seguimiento->comentario }}</div>
        <div><strong>Estatus:</strong> {{ $seguimiento->estatus }}</div>
        <div><strong>Fecha alta:</strong> {{ $seguimiento->created_at->format('d/m/Y H:i') }}</div>
        <div>
            <a href="{{ route('servicios_empresariales.seguimientos_ticket.index', $servicio->id) }}" class="btn btn-secondary mt-3">Regresar</a>
        </div>
    </div>
</div>
@endsection
