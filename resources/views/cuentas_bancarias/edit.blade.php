@extends('layouts.app')
@section('content')
<h2>Editar Cuenta Bancaria</h2>
<form method="POST" action="{{ route('cuentas_bancarias.update', $cuenta_bancaria) }}">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Banco</label>
        <input type="text" name="banco" class="form-control" value="{{ old('banco', $cuenta_bancaria->banco) }}" required>
    </div>
    <div class="mb-2">
        <label>No. Cuenta</label>
        <input type="text" name="numero_cuenta" class="form-control" value="{{ old('numero_cuenta', $cuenta_bancaria->numero_cuenta) }}" required>
    </div>
    <div class="mb-2">
        <label>CLABE</label>
        <input type="text" name="clabe" class="form-control" value="{{ old('clabe', $cuenta_bancaria->clabe) }}">
    </div>
    <div class="mb-2">
        <label>Saldo</label>
        <input type="number" step="0.01" name="saldo" class="form-control" value="{{ old('saldo', $cuenta_bancaria->saldo) }}">
    </div>
    <div class="mb-2">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="Activa" @selected(old('status', $cuenta_bancaria->status)=='Activa')>Activa</option>
            <option value="Inactiva" @selected(old('status', $cuenta_bancaria->status)=='Inactiva')>Inactiva</option>
        </select>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('cuentas_bancarias.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
