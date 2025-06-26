@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Editar Ticket (ID {{ $ticket->id }})</h1>

    <form action="{{ route('tickets_soporte.update', [$servicio->id, $ticket->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $ticket->titulo) }}" required>
            @error('titulo') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $ticket->descripcion) }}</textarea>
            @error('descripcion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-select" required>
                <option value="abierto" {{ old('estado', $ticket->estado) == 'abierto' ? 'selected' : '' }}>Abierto</option>
                <option value="en progreso" {{ old('estado', $ticket->estado) == 'en progreso' ? 'selected' : '' }}>En Progreso</option>
                <option value="cerrado" {{ old('estado', $ticket->estado) == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
            @error('estado') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Prioridad</label>
            <select name="prioridad" class="form-select" required>
                <option value="baja" {{ old('prioridad', $ticket->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('prioridad', $ticket->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('prioridad', $ticket->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
            </select>
            @error('prioridad') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Fecha de Apertura</label>
            <input type="date" name="fecha_apertura" class="form-control" value="{{ old('fecha_apertura', $ticket->fecha_apertura->format('Y-m-d')) }}" required>
            @error('fecha_apertura') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Fecha de Cierre</label>
            <input type="date" name="fecha_cierre" class="form-control" value="{{ old('fecha_cierre', $ticket->fecha_cierre ? $ticket->fecha_cierre->format('Y-m-d') : '') }}">
            @error('fecha_cierre') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Asignado a (ID Usuario)</label>
            <input type="number" name="asignado_a" class="form-control" value="{{ old('asignado_a', $ticket->asignado_a) }}">
            @error('asignado_a') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios', $ticket->comentarios) }}</textarea>
            @error('comentarios') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary" type="submit">Actualizar</button>
        <a href="{{ route('tickets_soporte.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
