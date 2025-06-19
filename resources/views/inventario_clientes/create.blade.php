@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Nuevo Equipo en Inventario</h2>
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventario_clientes.store') }}" method="POST" class="card shadow p-4 rounded-4">
        @csrf

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente <span class="text-danger">*</span></label>
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
            <label for="nombre_equipo" class="form-label">Nombre del Equipo <span class="text-danger">*</span></label>
            <input type="text" name="nombre_equipo" id="nombre_equipo" class="form-control" required value="{{ old('nombre_equipo') }}">
        </div>

        <div class="mb-3">
            <label for="tipo_equipo" class="form-label">Tipo de Equipo</label>
            <input type="text" name="tipo_equipo" id="tipo_equipo" class="form-control" value="{{ old('tipo_equipo') }}">
        </div>

        <div class="mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo') }}">
        </div>

        <div class="mb-3">
            <label for="serie" class="form-label">Serie</label>
            <input type="text" name="serie" id="serie" class="form-control" value="{{ old('serie') }}">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Guardar
            </button>
            <a href="{{ route('inventario_clientes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
