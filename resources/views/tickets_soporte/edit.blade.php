@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Ticket (Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b>)</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servicios_empresariales.tickets_soporte.update', [$servicio->id, $ticket->id]) }}" method="POST" class="card p-4 shadow">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $ticket->cliente_id) == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required value="{{ old('titulo', $ticket->titulo) }}">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $ticket->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="estatus" class="form-label">Estatus</label>
            <select name="estatus" id="estatus" class="form-select" required>
                <option value="Abierto" {{ old('estatus', $ticket->estatus) == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                <option value="En Proceso" {{ old('estatus', $ticket->estatus) == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                <option value="Cerrado" {{ old('estatus', $ticket->estatus) == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
        </div>
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('servicios_empresariales.tickets_soporte.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
