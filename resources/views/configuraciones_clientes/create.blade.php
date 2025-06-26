@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Agregar Configuración al Servicio #{{ $servicio->id }}</h2>
    <form action="{{ route('servicios_empresariales.configuraciones_clientes.store', $servicio->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tipo</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Dato</label>
            <input type="text" name="dato" class="form-control" required>
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('servicios_empresariales.configuraciones_clientes.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
