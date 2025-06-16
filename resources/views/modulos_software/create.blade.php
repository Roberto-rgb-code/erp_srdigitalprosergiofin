@extends('layouts.app')
@section('content')
<h2>Nuevo Módulo para {{ $proyecto->nombre }}</h2>
<form method="POST" action="{{ route('modulos_software.store', $proyecto->id) }}">
    @csrf
    <div class="mb-2">
        <label>Nombre del módulo:</label>
        <input type="text" name="nombre" class="form-control" required maxlength="80">
    </div>
    <div class="mb-2">
        <label>Porcentaje de avance:</label>
        <input type="number" name="porcentaje_avance" class="form-control" min="0" max="100" value="0">
    </div>
    <div class="mb-2">
        <label>Fase:</label>
        <select name="fase" class="form-control">
            <option>Diseño</option>
            <option>Desarrollo</option>
            <option>Testing</option>
            <option>Finalizado</option>
        </select>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('modulos_software.index', $proyecto->id) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
