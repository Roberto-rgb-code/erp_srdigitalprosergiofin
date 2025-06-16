@extends('layouts.app')
@section('content')
<h2>Registrar Egreso</h2>
<form method="POST" action="{{ route('egresos.store') }}">
    @csrf
    <div class="mb-2">
        <label>Tipo de egreso</label>
        <input type="text" name="tipo_egreso" class="form-control" value="{{ old('tipo_egreso') }}" required>
    </div>
    <div class="mb-2">
        <label>Monto</label>
        <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto') }}" required>
    </div>
    <div class="mb-2">
        <label>Fecha</label>
        <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->toDateString()) }}" required>
    </div>
    <div class="mb-2">
        <label>Cuenta bancaria</label>
        <select name="cuenta_bancaria_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            @foreach($cuentas as $c)
            <option value="{{ $c->id }}" @selected(old('cuenta_bancaria_id') == $c->id)>
                {{ $c->banco }} ({{ $c->numero_cuenta }})
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('egresos.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
