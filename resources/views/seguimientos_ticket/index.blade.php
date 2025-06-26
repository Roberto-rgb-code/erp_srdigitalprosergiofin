@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Seguimientos (Servicio #{{ $servicio->id }})</h2>
    <a href="{{ route('servicios_empresariales.seguimientos_ticket.create', $servicio->id) }}" class="btn btn-primary mb-3">Nuevo Seguimiento</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <table class="table">
        <thead>
            <tr>
                <th>Ticket</th><th>Comentario</th><th>Estatus</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($seguimientos as $seg)
            <tr>
                <td>{{ $seg->ticket->titulo ?? '-' }}</td>
                <td>{{ $seg->comentario }}</td>
                <td>{{ $seg->estatus }}</td>
                <td>
                    <a href="{{ route('servicios_empresariales.seguimientos_ticket.edit', [$servicio->id, $seg->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('servicios_empresariales.seguimientos_ticket.destroy', [$servicio->id, $seg->id]) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar seguimiento?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
