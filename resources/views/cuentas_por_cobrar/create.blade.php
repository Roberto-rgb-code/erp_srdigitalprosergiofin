@extends('layouts.app')
@section('content')
<h2>Nueva Cuenta por Cobrar</h2>
<form method="POST" action="{{ route('cuentas_por_cobrar.store') }}">
    @csrf
    <div class="mb-2">
        <label>Cliente</label>
        <select name="cliente_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            @foreach($clientes as $c)
            <option value="{{ $c->id }}" @selected(old('cliente_id') == $c->id)>
                {{ $c->nombre }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Venta</label>
        <select name="venta_id" class="form-select">
            <option value="">-- Selecciona --</option>
            @foreach($ventas as $v)
            <option value="{{ $v->id }}" @selected(old('venta_id') == $v->id)>
                {{ $v->id }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Monto</label>
        <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto') }}" required>
    </div>
    <div class="mb-2">
        <label>Saldo</label>
        <input type="number" step="0.01" name="saldo" class="form-control" value="{{ old('saldo') }}">
    </div>
    <div class="mb-2">
        <label>Fecha de vencimiento</label>
        <input type="date" name="fecha_vencimiento" class="form-control" value="{{ old('fecha_vencimiento') }}">
    </div>
    <div class="mb-2">
        <label>Fecha de pago</label>
        <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago') }}">
    </div>
    <div class="mb-2">
        <label>Estatus</label>
        <select name="estatus" class="form-select">
            <option value="Pendiente" @selected(old('estatus')=='Pendiente')>Pendiente</option>
            <option value="Pagada" @selected(old('estatus')=='Pagada')>Pagada</option>
            <option value="Vencida" @selected(old('estatus')=='Vencida')>Vencida</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Comentarios</label>
        <textarea name="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('cuentas_por_cobrar.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
