@extends('layouts.app')

@section('content')
<h2>Editar Servicio Empresarial</h2>

<form action="{{ route('servicios_empresariales.update', $servicio) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="cliente_id" class="form-label">Cliente</label>
        <select name="cliente_id" id="cliente_id" class="form-select" required>
            <option value="">Seleccione un cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id', $servicio->cliente_id) == $cliente->id ? 'selected' : '' }}>
                    {{ $cliente->nombre_completo ?? $cliente->empresa }}
                </option>
            @endforeach
        </select>
        @error('cliente_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="tipo_poliza" class="form-label">Tipo de Póliza</label>
        <input type="text" name="tipo_poliza" id="tipo_poliza" class="form-control" value="{{ old('tipo_poliza', $servicio->tipo_poliza) }}" required>
        @error('tipo_poliza')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="estatus" class="form-label">Estatus</label>
        <input type="text" name="estatus" id="estatus" class="form-control" value="{{ old('estatus', $servicio->estatus) }}" required>
        @error('estatus')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $servicio->fecha_inicio ? $servicio->fecha_inicio->format('Y-m-d') : '') }}" required>
        @error('fecha_inicio')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin', $servicio->fecha_fin ? $servicio->fecha_fin->format('Y-m-d') : '') }}">
        @error('fecha_fin')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="comentarios" class="form-label">Comentarios</label>
        <textarea name="comentarios" id="comentarios" class="form-control">{{ old('comentarios', $servicio->comentarios) }}</textarea>
        @error('comentarios')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
