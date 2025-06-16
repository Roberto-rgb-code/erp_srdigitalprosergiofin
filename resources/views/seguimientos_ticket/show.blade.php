@extends('layouts.app')
@section('content')
<h2>Detalle de Seguimiento</h2>
<table class="table">
    <tr><th>ID</th><td>{{ $seguimientos_ticket->id }}</td></tr>
    <tr><th>Ticket</th><td>{{ $seguimientos_ticket->ticket->folio ?? '' }}</td></tr>
    <tr><th>Comentario</th><td>{{ $seguimientos_ticket->comentario }}</td></tr>
    <tr><th>Usuario</th><td>{{ $seguimientos_ticket->usuario->nombre ?? '' }}</td></tr>
    <tr><th>Visibilidad</th><td>{{ $seguimientos_ticket->visibilidad }}</td></tr>
</table>
<a href="{{ route('seguimientos_ticket.edit', $seguimientos_ticket) }}" class="btn btn-warning">Editar</a>
<a href="{{ route('seguimientos_ticket.index') }}" class="btn btn-secondary">Volver</a>
@endsection
