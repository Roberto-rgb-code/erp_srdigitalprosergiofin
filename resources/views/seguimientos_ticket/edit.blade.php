@extends('layouts.app')
@section('content')
<h2>Editar Seguimiento de Ticket</h2>
@if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form action="{{ route('seguimientos_ticket.update', $seguimientos_ticket) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2"><label>Ticket:</label>
        <select name="ticket_id" class="form-control">
            @foreach($tickets as $t)
                <option value="{{ $t->id }}" @if($t->id == $seguimientos_ticket->ticket_id) selected @endif>{{ $t->folio }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Comentario:</label><textarea name="comentario" class="form-control">{{ $seguimientos_ticket->comentario }}</textarea></div>
    <div class="mb-2"><label>Usuario:</label>
        <select name="usuario_id" class="form-control">
            @foreach($usuarios as $u)
                <option value="{{ $u->id }}" @if($u->id == $seguimientos_ticket->usuario_id) selected @endif>{{ $u->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Visibilidad:</label>
        <select name="visibilidad" class="form-control">
            <option @if($seguimientos_ticket->visibilidad == 'Pública') selected @endif>Pública</option>
            <option @if($seguimientos_ticket->visibilidad == 'Interna') selected @endif>Interna</option>
        </select>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('seguimientos_ticket.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
