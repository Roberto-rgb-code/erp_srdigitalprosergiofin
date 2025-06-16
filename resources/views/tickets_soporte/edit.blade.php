@extends('layouts.app')
@section('content')
<h2>Editar Ticket de Soporte</h2>
@if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form action="{{ route('tickets_soporte.update', $tickets_soporte) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2"><label>Cliente:</label>
        <select name="cliente_id" class="form-control">
            @foreach($clientes as $c)
                <option value="{{ $c->id }}" @if($c->id == $tickets_soporte->cliente_id) selected @endif>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Poliza:</label>
        <select name="poliza_id" class="form-control">
            @foreach($polizas as $p)
                <option value="{{ $p->id }}" @if($p->id == $tickets_soporte->poliza_id) selected @endif>{{ $p->tipo }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Asunto:</label><input name="asunto" class="form-control" value="{{ $tickets_soporte->asunto }}"></div>
    <div class="mb-2"><label>Descripción:</label><textarea name="descripcion" class="form-control">{{ $tickets_soporte->descripcion }}</textarea></div>
    <div class="mb-2"><label>Equipo:</label>
        <select name="equipo_id" class="form-control"><option value="">N/A</option>
            @foreach($equipos as $e)<option value="{{ $e->id }}" @if($e->id == $tickets_soporte->equipo_id) selected @endif>{{ $e->nombre_equipo }}</option>@endforeach
        </select>
    </div>
    <div class="mb-2"><label>Responsable:</label>
        <select name="responsable_id" class="form-control"><option value="">N/A</option>
            @foreach($empleados as $em)<option value="{{ $em->id }}" @if($em->id == $tickets_soporte->responsable_id) selected @endif>{{ $em->nombre }}</option>@endforeach
        </select>
    </div>
    <div class="mb-2"><label>Prioridad:</label>
        <select name="prioridad" class="form-control">
            <option @if($tickets_soporte->prioridad == 'Baja') selected @endif>Baja</option>
            <option @if($tickets_soporte->prioridad == 'Media') selected @endif>Media</option>
            <option @if($tickets_soporte->prioridad == 'Alta') selected @endif>Alta</option>
        </select>
    </div>
    <div class="mb-2"><label>Estado:</label>
        <select name="estado" class="form-control">
            <option @if($tickets_soporte->estado == 'Pendiente') selected @endif>Pendiente</option>
            <option @if($tickets_soporte->estado == 'En proceso') selected @endif>En proceso</option>
            <option @if($tickets_soporte->estado == 'Resuelto') selected @endif>Resuelto</option>
            <option @if($tickets_soporte->estado == 'Cerrado') selected @endif>Cerrado</option>
        </select>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('tickets_soporte.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
