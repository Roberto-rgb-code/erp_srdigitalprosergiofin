@extends('layouts.app')
@section('content')
<h2>Editar asistencia de {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<form action="{{ route('recursos_humanos.asistencias.update', [$empleado, $asistencia]) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Fecha:</label>
        <input type="date" name="fecha" class="form-control" required value="{{ old('fecha', $asistencia->fecha) }}">
    </div>
    <div class="mb-2">
        <label>Tipo:</label>
        <select name="tipo" class="form-control" required>
            <option value="asistencia" @if($asistencia->tipo=='asistencia') selected @endif>Asistencia</option>
            <option value="retardo" @if($asistencia->tipo=='retardo') selected @endif>Retardo</option>
            <option value="falta" @if($asistencia->tipo=='falta') selected @endif>Falta</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Motivo:</label>
        <input type="text" name="motivo" class="form-control" value="{{ old('motivo', $asistencia->motivo) }}">
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('recursos_humanos.asistencias.index', $empleado) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
