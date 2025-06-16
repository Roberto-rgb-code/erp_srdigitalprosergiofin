@extends('layouts.app')
@section('content')
<h2>Nuevo Seguimiento de Ticket</h2>
@if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form action="{{ route('seguimientos_ticket.store') }}" method="POST">
    @csrf
    <div class="mb-2"><label>Ticket:</label>
        <select name="ticket_id" class="form-control">@foreach($tickets as $t)<option value="{{ $t->id }}">{{ $t->folio }}</option>@endforeach</select>
    </div>
    <div class="mb-2"><label>Comentario:</label><textarea name="comentario" class="form-control"></textarea></div>
    <div class="mb-2"><label>Usuario:</label>
        <select name="usuario_id" class="form-control">@foreach($usuarios as $u)<option value="{{ $u->id }}">{{ $u->nombre }}</option>@endforeach</select>
    </div>
    <div class="mb-2"><label>Visibilidad:</label>
        <select name="visibilidad" class="form-control">
            <option>Pública</option>
            <option>Interna</option>
        </select>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('seguimientos_ticket.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
