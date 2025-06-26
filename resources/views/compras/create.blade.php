@extends('layouts.app')
@section('content')
<div class="card mt-4">
    <div class="card-header">Nueva Compra</div>
    <div class="card-body">
        <form method="POST" action="{{ route('compras.store') }}">
            @csrf
            <div class="mb-3">
                <label>Proveedor</label>
                <input type="text" name="proveedor" class="form-control" value="{{ old('proveedor') }}" required>
            </div>
            <div class="mb-3">
                <label>Descripción</label>
                <input type="text" name="descripcion" class="form-control" required value="{{ old('descripcion') }}">
            </div>
            <div class="mb-3">
                <label>Monto</label>
                <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto') }}">
            </div>
            <div class="mb-3">
                <label>Fecha de compra</label>
                <input type="date" name="fecha_compra" class="form-control" required value="{{ old('fecha_compra') }}">
            </div>
            <div class="mb-3">
                <label>Método de pago</label>
                <select name="metodo_pago" class="form-select">
                    <option value="">Seleccione...</option>
                    <option value="transferencia" @selected(old('metodo_pago')=='transferencia')>Transferencia</option>
                    <option value="efectivo" @selected(old('metodo_pago')=='efectivo')>Efectivo</option>
                    <option value="linea_credito" @selected(old('metodo_pago')=='linea_credito')>Línea de crédito</option>
                    <option value="tarjeta" @selected(old('metodo_pago')=='tarjeta')>Pago con tarjeta</option>
                </select>
            </div>
            <div class="mb-3">
                <label>¿Factura?</label>
                <select name="factura" class="form-select">
                    <option value="0" @selected(old('factura')=='0')>No</option>
                    <option value="1" @selected(old('factura')=='1')>Sí</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Comentarios</label>
                <textarea name="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
            </div>
            <button class="btn btn-success">Guardar compra</button>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
