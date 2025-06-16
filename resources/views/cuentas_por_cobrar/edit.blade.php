@extends('layouts.app')
@section('content')
<h2>Editar Cuenta por Cobrar</h2>
<form method="POST" action="{{ route('cuentas_por_cobrar.update', $cuentas_por_cobrar) }}">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Cliente</label>
        <select name="cliente_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            @foreach($clientes as $c)
            <option value="{{ $c->id }}" @selected(old('cliente_id', $cuentas_por_cobrar->cliente_id) == $c->id)>
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
            <option value="{{ $v->id }}" @selected(old('venta_id', $cuentas_por_cobrar->venta_id) == $v->id)>
                {{ $v->id }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Monto</label>
        <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto', $cuentas_por_cobrar->monto) }}" required>
    </div>
    <div class="mb-2">
        <label>Saldo</label>
        <input type="number" step="0.01" name="saldo" class="form-control" value="{{ old('saldo', $cuentas_por_cobrar->saldo) }}">
    </div>
    <div class="mb-2">
        <label>Fecha de vencimiento</label>
        <input type="date" name="fecha_vencimiento" class="form-control" value="{{ old('fecha_vencimiento', $cuentas_por_cobrar->fecha_vencimiento) }}">
    </div>
    <div class="mb-2">
        <label>Fecha de pago</label>
        <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', $cuentas_por_cobrar->fecha_pago) }}">
    </div>
    <div class="mb-2">
        <label>Estatus</label>
        <select name="estatus" class="form-select">
            <option value="Pendiente" @selected(old('estatus', $cuentas_por_cobrar->estatus)=='Pendiente')>Pendiente</option>
            <option value="Pagada" @selected(old('estatus', $cuentas_por_cobrar->estatus)=='Pagada')>Pagada</option>
            <option value="Vencida" @selected(old('estatus', $cuentas_por_cobrar->estatus)=='Vencida')>Vencida</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Comentarios</label>
        <textarea name="comentarios" class="form-control">{{ old('comentarios', $cuentas_por_cobrar->comentarios) }}</textarea>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('cuentas_por_cobrar.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
