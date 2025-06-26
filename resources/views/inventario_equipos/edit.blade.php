@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Editar Equipo (ID {{ $inventario->id }})</h1>

    <form action="{{ route('inventario_equipos.update', [$servicio->id, $inventario->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Tipo de Equipo</label>
            <input type="text" name="tipo_equipo" class="form-control" required value="{{ old('tipo_equipo', $inventario->tipo_equipo) }}">
            @error('tipo_equipo') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Marca</label>
            <input type="text" name="marca" class="form-control" value="{{ old('marca', $inventario->marca) }}">
        </div>
        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control" value="{{ old('modelo', $inventario->modelo) }}">
        </div>
        <div class="mb-3">
            <label>Número de Serie</label>
            <input type="text" name="numero_serie" class="form-control" value="{{ old('numero_serie', $inventario->numero_serie) }}">
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $inventario->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Estado</label>
            <input type="text" name="estado" class="form-control" value="{{ old('estado', $inventario->estado) }}">
        </div>

        <button class="btn btn-primary" type="submit">Actualizar</button>
        <a href="{{ route('inventario_equipos.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
