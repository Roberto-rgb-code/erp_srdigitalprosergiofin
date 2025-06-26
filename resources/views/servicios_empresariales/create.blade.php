@extends('layouts.app')

@section('content')
<h2>Crear Servicio Empresarial</h2>

<form action="{{ route('servicios_empresariales.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="cliente_id" class="form-label">Cliente</label>
        <select name="cliente_id" id="cliente_id" class="form-select" required>
            <option value="">Seleccione un cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
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
        <input type="text" name="tipo_poliza" id="tipo_poliza" class="form-control" value="{{ old('tipo_poliza') }}" required>
        @error('tipo_poliza')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="estatus" class="form-label">Estatus</label>
        <input type="text" name="estatus" id="estatus" class="form-control" value="{{ old('estatus', 'activo') }}" required>
        @error('estatus')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
        @error('fecha_inicio')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
        @error('fecha_fin')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="comentarios" class="form-label">Comentarios</label>
        <textarea name="comentarios" id="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
        @error('comentarios')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
