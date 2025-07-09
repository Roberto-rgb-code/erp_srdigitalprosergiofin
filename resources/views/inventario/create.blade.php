@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Nuevo Producto en Inventario</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('inventario.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label for="proveedor_id">Proveedor *</label>
                <select name="proveedor_id" id="proveedor_id" class="form-select" required>
                    <option value="">Seleccione...</option>
                    @foreach($proveedores as $p)
                        <option value="{{ $p->id }}" {{ old('proveedor_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="tipo_producto">Tipo de Producto *</label>
                <input type="text" name="tipo_producto" id="tipo_producto" class="form-control" required value="{{ old('tipo_producto') }}">
            </div>
            <div class="col-md-4">
                <label for="producto">Producto *</label>
                <input type="text" name="producto" id="producto" class="form-control" required value="{{ old('producto') }}">
            </div>
            <div class="col-md-3">
                <label for="sku">SKU *</label>
                <input type="text" name="sku" id="sku" class="form-control" required value="{{ old('sku') }}">
            </div>
            <div class="col-md-3">
                <label for="cantidad">Cantidad *</label>
                <input type="number" name="cantidad" id="cantidad" min="1" class="form-control" required value="{{ old('cantidad', 1) }}">
            </div>
            <div class="col-md-3">
                <label for="costo_unitario">Costo Unitario (sin IVA) *</label>
                <input type="number" name="costo_unitario" id="costo_unitario" min="0" step="0.01" class="form-control" required value="{{ old('costo_unitario', 0) }}">
            </div>
            <div class="col-md-3">
                <label for="precio_venta">Precio Venta *</label>
                <input type="number" name="precio_venta" id="precio_venta" min="0" step="0.01" class="form-control" required value="{{ old('precio_venta', 0) }}">
            </div>
            <div class="col-md-3">
                <label for="precio_mayoreo">Precio Mayoreo *</label>
                <input type="number" name="precio_mayoreo" id="precio_mayoreo" min="0" step="0.01" class="form-control" required value="{{ old('precio_mayoreo', 0) }}">
            </div>
            <div class="col-md-3">
                <label for="costo_total">Costo Total Neto *</label>
                <input type="number" name="costo_total" id="costo_total" min="0" step="0.01" class="form-control" required value="{{ old('costo_total', 0) }}">
            </div>
            <div class="col-md-12">
                <div class="alert alert-info mt-2">
                    El número de serie de cada unidad podrá ser gestionado después del alta del producto desde la vista detallada.
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
