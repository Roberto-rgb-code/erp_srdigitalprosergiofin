@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($cuentas_contable) ? 'Editar Cuenta' : 'Nueva Cuenta' }}</h2>

    <form method="POST" action="{{ isset($cuentas_contable) ? route('cuentas_contables.update', $cuentas_contable) : route('cuentas_contables.store') }}">
        @csrf
        @if(isset($cuentas_contable))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $cuentas_contable->codigo ?? '') }}" required>
            @error('codigo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cuentas_contable->nombre ?? '') }}" required>
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-control" required>
                <option value="">-- Selecciona --</option>
                <option value="Activo" {{ old('tipo', $cuentas_contable->tipo ?? '') == 'Activo' ? 'selected' : '' }}>Activo</option>
                <option value="Pasivo" {{ old('tipo', $cuentas_contable->tipo ?? '') == 'Pasivo' ? 'selected' : '' }}>Pasivo</option>
                <option value="Capital" {{ old('tipo', $cuentas_contable->tipo ?? '') == 'Capital' ? 'selected' : '' }}>Capital</option>
                <option value="Ingreso" {{ old('tipo', $cuentas_contable->tipo ?? '') == 'Ingreso' ? 'selected' : '' }}>Ingreso</option>
                <option value="Gasto" {{ old('tipo', $cuentas_contable->tipo ?? '') == 'Gasto' ? 'selected' : '' }}>Gasto</option>
            </select>
            @error('tipo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Cuenta Padre (opcional)</label>
            <select name="cuenta_padre_id" class="form-control">
                <option value="">-- Ninguna --</option>
                @foreach($padres as $padre)
                    <option value="{{ $padre->id }}" {{ old('cuenta_padre_id', $cuentas_contable->cuenta_padre_id ?? '') == $padre->id ? 'selected' : '' }}>
                        {{ $padre->nombre }}
                    </option>
                @endforeach
            </select>
            @error('cuenta_padre_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('cuentas_contables.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
