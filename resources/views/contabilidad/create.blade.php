@extends('layouts.app')
@section('content')
<div class="container">
    <h2>{{ isset($cuenta) ? 'Editar' : 'Nueva' }} Cuenta Contable</h2>
    <form method="POST" action="{{ isset($cuenta) ? route('cuentas_contables.update', $cuenta) : route('cuentas_contables.store') }}">
        @csrf
        @if(isset($cuenta)) @method('PUT') @endif
        <div class="mb-2">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $cuenta->codigo ?? '') }}" required>
        </div>
        <div class="mb-2">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cuenta->nombre ?? '') }}" required>
        </div>
        <div class="mb-2">
            <label>Tipo</label>
            <select name="tipo" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach(['Activo','Pasivo','Capital','Ingreso','Gasto'] as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo', $cuenta->tipo ?? '') == $tipo)>{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Cuenta Padre</label>
            <select name="cuenta_padre_id" class="form-select">
                <option value="">-- Ninguna --</option>
                @foreach($cuentas as $padre)
                <option value="{{ $padre->id }}" @selected(old('cuenta_padre_id', $cuenta->cuenta_padre_id ?? '') == $padre->id)>
                    {{ $padre->nombre }} ({{ $padre->codigo }})
                </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success" type="submit">Guardar</button>
        <a href="{{ route('cuentas_contables.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
