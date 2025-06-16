@extends('layouts.app')
@section('content')
<h2>Editar Módulo para {{ $proyecto->nombre }}</h2>
<form method="POST" action="{{ route('modulos_software.update', [$proyecto->id, $modulo->id]) }}">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Nombre del módulo:</label>
        <input type="text" name="nombre" class="form-control" required maxlength="80" value="{{ $modulo->nombre }}">
    </div>
    <div class="mb-2">
        <label>Porcentaje de avance:</label>
        <input type="number" name="porcentaje_avance" class="form-control" min="0" max="100" value="{{ $modulo->porcentaje_avance }}">
    </div>
    <div class="mb-2">
        <label>Fase:</label>
        <select name="fase" class="form-control">
            @foreach(['Diseño','Desarrollo','Testing','Finalizado'] as $f)
                <option @if($modulo->fase == $f) selected @endif>{{ $f }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('modulos_software.index', $proyecto->id) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
