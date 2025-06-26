@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Nuevo Seguimiento para Servicio #{{ $servicio->id }}</h2>
    <form action="{{ route('servicios_empresariales.seguimientos_ticket.store', $servicio->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Ticket</label>
            <select name="ticket_soporte_id" class="form-control" required>
                <option value="">-- Selecciona Ticket --</option>
                @foreach($tickets as $ticket)
                    <option value="{{ $ticket->id }}">{{ $ticket->titulo }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Comentario</label>
            <textarea name="comentario" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Estatus</label>
            <input type="text" name="estatus" class="form-control" required>
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('servicios_empresariales.seguimientos_ticket.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
