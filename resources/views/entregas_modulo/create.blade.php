@extends('layouts.app')
@section('content')
<h2>Nueva Entrega para {{ $modulo->nombre }}</h2>
<form method="POST" action="{{ route('modulos_software.entregas.store', [$proyecto, $modulo->id]) }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <label>Descripción:</label>
        <textarea name="descripcion" class="form-control"></textarea>
    </div>
    <div class="mb-2">
        <label>Archivo (opcional):</label>
        <input type="file" name="archivo" class="form-control">
    </div>
    <div class="mb-2">
        <label>Versión:</label>
        <input type="text" name="version" class="form-control" maxlength="20">
    </div>
    <div class="mb-2">
        <label>Fecha:</label>
        <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}">
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('modulos_software.entregas.index', [$proyecto, $modulo->id]) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
