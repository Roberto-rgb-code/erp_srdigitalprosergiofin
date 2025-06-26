@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Agregar Equipo al Inventario (Servicio #{{ $servicio->id }})</h1>

    <form action="{{ route('inventario_equipos.store', $servicio->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tipo de Equipo</label>
            <input type="text" name="tipo_equipo" class="form-control" required value="{{ old('tipo_equipo') }}">
            @error('tipo_equipo') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Marca</label>
            <input type="text" name="marca" class="form-control" value="{{ old('marca') }}">
        </div>
        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control" value="{{ old('modelo') }}">
        </div>
        <div class="mb-3">
            <label>Número de Serie</label>
            <input type="text" name="numero_serie" class="form-control" value="{{ old('numero_serie') }}">
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Estado</label>
            <input type="text" name="estado" class="form-control" value="{{ old('estado', 'activo') }}">
        </div>

        <button class="btn btn-primary" type="submit">Guardar</button>
        <a href="{{ route('inventario_equipos.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
