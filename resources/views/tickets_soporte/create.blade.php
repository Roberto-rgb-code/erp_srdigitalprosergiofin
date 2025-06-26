@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Nuevo Ticket de Soporte (Servicio #{{ $servicio->id }})</h1>

    <form action="{{ route('tickets_soporte.store', $servicio->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
            @error('titulo') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
            @error('descripcion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-select" required>
                <option value="abierto" {{ old('estado')=='abierto' ? 'selected' : '' }}>Abierto</option>
                <option value="en progreso" {{ old('estado')=='en progreso' ? 'selected' : '' }}>En Progreso</option>
                <option value="cerrado" {{ old('estado')=='cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
            @error('estado') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Prioridad</label>
            <select name="prioridad" class="form-select" required>
                <option value="baja" {{ old('prioridad')=='baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('prioridad')=='media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('prioridad')=='alta' ? 'selected' : '' }}>Alta</option>
            </select>
            @error('prioridad') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Fecha de Apertura</label>
            <input type="date" name="fecha_apertura" class="form-control" value="{{ old('fecha_apertura', date('Y-m-d')) }}" required>
            @error('fecha_apertura') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Fecha de Cierre</label>
            <input type="date" name="fecha_cierre" class="form-control" value="{{ old('fecha_cierre') }}">
            @error('fecha_cierre') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Asignado a (ID Usuario)</label>
            <input type="number" name="asignado_a" class="form-control" value="{{ old('asignado_a') }}">
            @error('asignado_a') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
            @error('comentarios') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary" type="submit">Guardar</button>
        <a href="{{ route('tickets_soporte.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
