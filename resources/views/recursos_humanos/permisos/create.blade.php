@extends('layouts.app')
@section('content')
<h2>Nuevo permiso para {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<form action="{{ route('recursos_humanos.permisos.store', $empleado) }}" method="POST">
    @csrf
    <div class="mb-2">
        <label>Fecha inicio:</label>
        <input type="date" name="fecha_inicio" class="form-control" required value="{{ old('fecha_inicio') }}">
    </div>
    <div class="mb-2">
        <label>Fecha fin:</label>
        <input type="date" name="fecha_fin" class="form-control" required value="{{ old('fecha_fin') }}">
    </div>
    <div class="mb-2">
        <label>Motivo:</label>
        <input type="text" name="motivo" class="form-control" required value="{{ old('motivo') }}">
    </div>
    <div class="mb-2">
        <label>Aprobado:</label>
        <select name="aprobado" class="form-control">
            <option value="1" @selected(old('aprobado')=='1')>Sí</option>
            <option value="0" @selected(old('aprobado')=='0')>No</option>
        </select>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('recursos_humanos.permisos.index', $empleado) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
