@extends('layouts.app')
@section('content')
<h2>Editar empleado</h2>
<form action="{{ route('recursos_humanos.update', $empleado) }}" method="POST">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-2">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required maxlength="80" value="{{ $empleado->nombre }}">
        </div>
        <div class="col-md-6 mb-2">
            <label>Apellido:</label>
            <input type="text" name="apellido" class="form-control" maxlength="80" value="{{ $empleado->apellido }}">
        </div>
        <div class="col-md-4 mb-2">
            <label>Puesto:</label>
            <select name="puesto_empleado_id" class="form-control">
                <option value="">Seleccione...</option>
                @foreach($puestos as $p)
                    <option value="{{ $p->id }}" @if($p->id == $empleado->puesto_empleado_id) selected @endif>{{ $p->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <label>Fecha ingreso:</label>
            <input type="date" name="fecha_ingreso" class="form-control" required value="{{ $empleado->fecha_ingreso }}">
        </div>
        <div class="col-md-4 mb-2">
            <label>Estatus:</label>
            <select name="status" class="form-control">
                <option @if($empleado->status == 'Activo') selected @endif>Activo</option>
                <option @if($empleado->status == 'Inactivo') selected @endif>Inactivo</option>
                <option @if($empleado->status == 'Baja') selected @endif>Baja</option>
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <label>RFC:</label>
            <input type="text" name="rfc" class="form-control" value="{{ $empleado->rfc }}">
        </div>
        <div class="col-md-4 mb-2">
            <label>CURP:</label>
            <input type="text" name="curp" class="form-control" value="{{ $empleado->curp }}">
        </div>
        <div class="col-md-4 mb-2">
            <label>Notas internas:</label>
            <textarea name="notas" class="form-control">{{ $empleado->notas }}</textarea>
        </div>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('recursos_humanos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
