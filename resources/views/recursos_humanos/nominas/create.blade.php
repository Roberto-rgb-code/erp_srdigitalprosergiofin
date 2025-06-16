@extends('layouts.app')
@section('content')
<h2>Nueva nómina para {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<form action="{{ route('recursos_humanos.nominas.store', $empleado) }}" method="POST">
    @csrf
    <div class="mb-2">
        <label>Sueldo base:</label>
        <input type="number" step="0.01" name="sueldo_base" class="form-control" required value="{{ old('sueldo_base') }}">
    </div>
    <div class="mb-2">
        <label>Monto pagado:</label>
        <input type="number" step="0.01" name="monto_pagado" class="form-control" required value="{{ old('monto_pagado') }}">
    </div>
    <div class="mb-2">
        <label>Tipo de pago:</label>
        <select name="tipo_pago" class="form-control" required>
            <option value="transferencia">Transferencia</option>
            <option value="efectivo">Efectivo</option>
            <option value="cheque">Cheque</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Cuenta bancaria:</label>
        <input type="text" name="cuenta_bancaria" class="form-control" value="{{ old('cuenta_bancaria') }}">
    </div>
    <div class="mb-2">
        <label>Fecha de pago:</label>
        <input type="date" name="fecha_pago" class="form-control" required value="{{ old('fecha_pago') }}">
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('recursos_humanos.nominas.index', $empleado) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
