@extends('layouts.app')
@section('content')
<h2>Subir documento para {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<form action="{{ route('recursos_humanos.documentos.store', $empleado) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <label>Nombre del documento:</label>
        <input type="text" name="nombre_documento" class="form-control" required value="{{ old('nombre_documento') }}">
    </div>
    <div class="mb-2">
        <label>Archivo (PDF, JPG, PNG, DOC, DOCX):</label>
        <input type="file" name="archivo" class="form-control" required>
    </div>
    <button class="btn btn-success">Subir</button>
    <a href="{{ route('recursos_humanos.documentos.index', $empleado) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
