@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nueva Configuración Técnica (Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b>)</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servicios_empresariales.configuraciones_clientes.store', $servicio->id) }}" method="POST" class="card p-4 shadow">
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
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" name="tipo" id="tipo" class="form-control" required value="{{ old('tipo') }}">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion') }}">
        </div>
        <div class="mb-3">
            <label for="dato" class="form-label">Dato</label>
            <input type="text" name="dato" id="dato" class="form-control" required value="{{ old('dato') }}">
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('servicios_empresariales.configuraciones_clientes.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
