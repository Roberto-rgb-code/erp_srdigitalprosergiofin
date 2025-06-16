@extends('layouts.app')
@section('content')
<h2>Editar Proyecto de Software</h2>
<form method="POST" action="{{ route('desarrollo_software.update', $desarrollo_software) }}">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Cliente:</label>
        <select name="cliente_id" class="form-control" required>
            @foreach($clientes as $c)
                <option value="{{ $c->id }}" @if($c->id == $desarrollo_software->cliente_id) selected @endif>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Nombre del proyecto:</label>
        <input type="text" name="nombre" class="form-control" value="{{ $desarrollo_software->nombre }}" required maxlength="100">
    </div>
    <div class="mb-2">
        <label>Tipo de software:</label>
        <select name="tipo_software_id" class="form-control" required>
            @foreach($tipos as $t)
                <option value="{{ $t->id }}" @if($t->id == $desarrollo_software->tipo_software_id) selected @endif>{{ $t->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Stack tecnológico:</label>
        <input type="text" name="stack_tecnologico" class="form-control" maxlength="150" value="{{ $desarrollo_software->stack_tecnologico }}">
    </div>
    <div class="mb-2">
        <label>Fecha inicio:</label>
        <input type="date" name="fecha_inicio" class="form-control" value="{{ $desarrollo_software->fecha_inicio }}" required>
    </div>
    <div class="mb-2">
        <label>Fecha entrega (opcional):</label>
        <input type="date" name="fecha_fin" class="form-control" value="{{ $desarrollo_software->fecha_fin }}">
    </div>
    <div class="mb-2">
        <label>Responsable:</label>
        <select name="responsable_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($responsables as $r)
                <option value="{{ $r->id }}" @if($r->id == $desarrollo_software->responsable_id) selected @endif>{{ $r->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Estado:</label>
        <select name="estado" class="form-control" required>
            @foreach(['Planeado','En desarrollo','Testing','Finalizado'] as $estado)
                <option @if($desarrollo_software->estado == $estado) selected @endif>{{ $estado }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Historial/Notas:</label>
        <textarea name="historial" class="form-control">{{ $desarrollo_software->historial }}</textarea>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('desarrollo_software.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
