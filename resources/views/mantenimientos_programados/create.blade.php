@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Nuevo Mantenimiento Programado (Servicio #{{ $servicio->id }})</h1>

    <form action="{{ route('mantenimientos_programados.store', $servicio->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required>{{ old('descripcion') }}</textarea>
            @error('descripcion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Fecha Programada</label>
            <input type="date" name="fecha_programada" class="form-control" value="{{ old('fecha_programada', date('Y-m-d')) }}" required>
            @error('fecha_programada') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-select" required>
                <option value="pendiente" {{ old('estado')=='pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="completado" {{ old('estado')=='completado' ? 'selected' : '' }}>Completado</option>
                <option value="cancelado" {{ old('estado')=='cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            @error('estado') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
            @error('comentarios') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary" type="submit">Guardar</button>
        <a href="{{ route('mantenimientos_programados.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
