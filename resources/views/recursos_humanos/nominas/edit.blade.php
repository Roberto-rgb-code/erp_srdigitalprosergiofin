@extends('layouts.app')
@section('content')
<h2>Editar nómina de {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<form action="{{ route('recursos_humanos.nominas.update', [$empleado, $nomina]) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Sueldo base:</label>
        <input type="number" step="0.01" name="sueldo_base" class="form-control" required value="{{ old('sueldo_base', $nomina->sueldo_base) }}">
    </div>
    <div class="mb-2">
        <label>Monto pagado:</label>
        <input type="number" step="0.01" name="monto_pagado" class="form-control" required value="{{ old('monto_pagado', $nomina->monto_pagado) }}">
    </div>
    <div class="mb-2">
        <label>Tipo de pago:</label>
        <select name="tipo_pago" class="form-control" required>
            <option value="transferencia" @if($nomina->tipo_pago=='transferencia') selected @endif>Transferencia</option>
            <option value="efectivo" @if($nomina->tipo_pago=='efectivo') selected @endif>Efectivo</option>
            <option value="cheque" @if($nomina->tipo_pago=='cheque') selected @endif>Cheque</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Cuenta bancaria:</label>
        <input type="text" name="cuenta_bancaria" class="form-control" value="{{ old('cuenta_bancaria', $nomina->cuenta_bancaria) }}">
    </div>
    <div class="mb-2">
        <label>Fecha de pago:</label>
        <input type="date" name="fecha_pago" class="form-control" required value="{{ old('fecha_pago', $nomina->fecha_pago) }}">
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('recursos_humanos.nominas.index', $empleado) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
