@extends('layouts.app')
@section('content')
<h2>Nueva asistencia para {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<form action="{{ route('recursos_humanos.asistencias.store', $empleado) }}" method="POST">
    @csrf
    <div class="mb-2">
        <label>Fecha:</label>
        <input type="date" name="fecha" class="form-control" required value="{{ old('fecha') }}">
    </div>
    <div class="mb-2">
        <label>Tipo:</label>
        <select name="tipo" class="form-control" required>
            <option value="asistencia">Asistencia</option>
            <option value="retardo">Retardo</option>
            <option value="falta">Falta</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Motivo:</label>
        <input type="text" name="motivo" class="form-control" value="{{ old('motivo') }}">
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('recursos_humanos.asistencias.index', $empleado) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
