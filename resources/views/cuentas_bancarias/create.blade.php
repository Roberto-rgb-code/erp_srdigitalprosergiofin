@extends('layouts.app')
@section('content')
<h2>Nueva Cuenta Bancaria</h2>
<form method="POST" action="{{ route('cuentas_bancarias.store') }}">
    @csrf
    <div class="mb-2">
        <label>Banco</label>
        <input type="text" name="banco" class="form-control" value="{{ old('banco') }}" required>
    </div>
    <div class="mb-2">
        <label>No. Cuenta</label>
        <input type="text" name="numero_cuenta" class="form-control" value="{{ old('numero_cuenta') }}" required>
    </div>
    <div class="mb-2">
        <label>CLABE</label>
        <input type="text" name="clabe" class="form-control" value="{{ old('clabe') }}">
    </div>
    <div class="mb-2">
        <label>Saldo</label>
        <input type="number" step="0.01" name="saldo" class="form-control" value="{{ old('saldo') }}">
    </div>
    <div class="mb-2">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="Activa" @selected(old('status')=='Activa')>Activa</option>
            <option value="Inactiva" @selected(old('status')=='Inactiva')>Inactiva</option>
        </select>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('cuentas_bancarias.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
