@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Inventario</h2>

    <form action="{{ route('inventario_clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="servicio_empresarial_id" class="form-label">Servicio Empresarial</label>
            <select name="servicio_empresarial_id" id="servicio_empresarial_id" class="form-select" required>
                <option value="">-- Seleccione un servicio empresarial --</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ old('servicio_empresarial_id') == $servicio->id ? 'selected' : '' }}>
                        {{ $servicio->poliza }} - {{ $servicio->cliente->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
            @error('servicio_empresarial_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nombre_equipo" class="form-label">Nombre Equipo</label>
            <input type="text" name="nombre_equipo" id="nombre_equipo" class="form-control" value="{{ old('nombre_equipo') }}" required>
            @error('nombre_equipo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="numero_serie" class="form-label">Número de Serie</label>
            <input type="text" name="numero_serie" id="numero_serie" class="form-control" value="{{ old('numero_serie') }}">
            @error('numero_serie')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('inventario_clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
