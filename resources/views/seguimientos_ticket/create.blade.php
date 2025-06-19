@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nuevo Seguimiento de Ticket (Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b>)</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servicios_empresariales.seguimientos_ticket.store', $servicio->id) }}" method="POST" class="card p-4 shadow">
        @csrf

        <div class="mb-3">
            <label for="ticket_soporte_id" class="form-label">Ticket</label>
            <select name="ticket_soporte_id" id="ticket_soporte_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach ($tickets as $ticket)
                    <option value="{{ $ticket->id }}" {{ old('ticket_soporte_id') == $ticket->id ? 'selected' : '' }}>
                        {{ $ticket->titulo }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="comentario" class="form-label">Comentario</label>
            <textarea name="comentario" id="comentario" class="form-control">{{ old('comentario') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="estatus" class="form-label">Estatus</label>
            <select name="estatus" id="estatus" class="form-select" required>
                <option value="En revisión" {{ old('estatus') == 'En revisión' ? 'selected' : '' }}>En revisión</option>
                <option value="En proceso" {{ old('estatus') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="Solucionado" {{ old('estatus') == 'Solucionado' ? 'selected' : '' }}>Solucionado</option>
            </select>
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('servicios_empresariales.seguimientos_ticket.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
