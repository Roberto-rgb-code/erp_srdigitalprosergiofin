@extends('layouts.app')
@section('content')
<h2>Editar documento de {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<form action="{{ route('recursos_humanos.documentos.update', [$empleado, $documento]) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Nombre del documento:</label>
        <input type="text" name="nombre" class="form-control" required value="{{ old('nombre', $documento->nombre) }}">
    </div>
    <div class="mb-2">
        <label>Archivo actual:</label><br>
        @if($documento->archivo)
            <a href="{{ asset('storage/' . $documento->archivo) }}" target="_blank">Ver archivo</a>
        @endif
    </div>
    <div class="mb-2">
        <label>Reemplazar archivo (opcional):</label>
        <input type="file" name="archivo" class="form-control">
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('recursos_humanos.documentos.index', $empleado) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
