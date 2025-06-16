@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nuevo Servicio Empresarial</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servicios_empresariales.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="poliza" class="form-label">Póliza</label>
            <input type="text" name="poliza" id="poliza" class="form-control" required value="{{ old('poliza') }}" placeholder="Nombre, número o folio de póliza">
        </div>

        <div class="mb-3">
            <label for="estatus" class="form-label">Estatus</label>
            <select name="estatus" id="estatus" class="form-select" required>
                <option value="Activa" {{ old('estatus') == 'Activa' ? 'selected' : '' }}>Activa</option>
                <option value="Inactiva" {{ old('estatus') == 'Inactiva' ? 'selected' : '' }}>Inactiva</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="comentarios" class="form-label">Comentarios</label>
            <textarea name="comentarios" id="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
