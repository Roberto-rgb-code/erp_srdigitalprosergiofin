@extends('layouts.app')
@section('content')
<h2>Seguimiento de Ticket</h2>
<a href="{{ route('seguimientos_ticket.create') }}" class="btn btn-primary mb-2">Nuevo comentario</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Ticket</th><th>Comentario</th><th>Usuario</th><th>Visibilidad</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($seguimientos as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->ticket->folio ?? '' }}</td>
            <td>{{ $s->comentario }}</td>
            <td>{{ $s->usuario->nombre ?? '' }}</td>
            <td>{{ $s->visibilidad }}</td>
            <td>
                <a href="{{ route('seguimientos_ticket.show', $s) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('seguimientos_ticket.edit', $s) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('seguimientos_ticket.destroy', $s) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
