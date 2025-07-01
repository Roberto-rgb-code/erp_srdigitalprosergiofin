@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Nueva Compra</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('compras.store') }}">
        @csrf
        <div class="mb-3">
            <label for="proveedor">Proveedor *</label>
            <input type="text" name="proveedor" id="proveedor" class="form-control" required value="{{ old('proveedor') }}">
        </div>

        <div class="mb-3">
            <label for="descripcion">Descripción *</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" required value="{{ old('descripcion') }}">
        </div>

        <div class="mb-3">
            <label for="monto">Monto</label>
            <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ old('monto') }}">
        </div>

        <div class="mb-3">
            <label for="fecha_compra">Fecha de Compra *</label>
            <input type="date" name="fecha_compra" id="fecha_compra" class="form-control" required value="{{ old('fecha_compra') }}">
        </div>

        <div class="mb-3">
            <label for="metodo_pago">Método de Pago</label>
            <select name="metodo_pago" id="metodo_pago" class="form-select">
                <option value="">Seleccione...</option>
                <option value="transferencia" @selected(old('metodo_pago') == 'transferencia')>Transferencia</option>
                <option value="efectivo" @selected(old('metodo_pago') == 'efectivo')>Efectivo</option>
                <option value="linea_credito" @selected(old('metodo_pago') == 'linea_credito')>Línea de crédito</option>
                <option value="tarjeta" @selected(old('metodo_pago') == 'tarjeta')>Pago con tarjeta</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="factura">¿Factura?</label>
            <select name="factura" id="factura" class="form-select">
                <option value="0" @selected(old('factura') == '0')>No</option>
                <option value="1" @selected(old('factura') == '1')>Sí</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="comentarios">Comentarios</label>
            <textarea name="comentarios" id="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar Compra</button>
        <a href="{{ route('compras.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
