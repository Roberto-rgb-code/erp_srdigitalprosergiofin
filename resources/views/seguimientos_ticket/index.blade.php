@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Seguimientos de Ticket — Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b></h2>
    <a href="{{ route('servicios_empresariales.seguimientos_ticket.create', $servicio->id) }}" class="btn btn-primary mb-2">Nuevo Seguimiento</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ticket</th>
                <th>Cliente</th>
                <th>Comentario</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($seguimientos as $s)
            <tr>
                <td>{{ $s->id }}</td>
                <td>{{ $s->ticket->titulo ?? '' }}</td>
                <td>{{ $s->cliente->nombre ?? '' }}</td>
                <td>{{ $s->comentario }}</td>
                <td>{{ $s->estatus }}</td>
                <td>
                    <a href="{{ route('servicios_empresariales.seguimientos_ticket.show', [$servicio->id, $s->id]) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('servicios_empresariales.seguimientos_ticket.edit', [$servicio->id, $s->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('servicios_empresariales.seguimientos_ticket.destroy', [$servicio->id, $s->id]) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
