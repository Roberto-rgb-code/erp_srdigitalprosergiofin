@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Editar Mantenimiento (ID {{ $mantenimiento->id }})</h1>

    <form action="{{ route('mantenimientos_programados.update', [$servicio->id, $mantenimiento->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required>{{ old('descripcion', $mantenimiento->descripcion) }}</textarea>
            @error('descripcion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Fecha Programada</label>
            <input type="date" name="fecha_programada" class="form-control" value="{{ old('fecha_programada', $mantenimiento->fecha_programada->format('Y-m-d')) }}" required>
            @error('fecha_programada') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-select" required>
                <option value="pendiente" {{ old('estado', $mantenimiento->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="completado" {{ old('estado', $mantenimiento->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                <option value="cancelado" {{ old('estado', $mantenimiento->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            @error('estado') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios', $mantenimiento->comentarios) }}</textarea>
            @error('comentarios') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary" type="submit">Actualizar</button>
        <a href="{{ route('mantenimientos_programados.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
