@php $isEdit = isset($producto); @endphp

<div class="row g-3">
    @if($isEdit)
        <div class="col-md-4">
            <label>Folio</label>
            <input type="text" class="form-control" value="{{ $producto->folio }}" readonly>
        </div>
    @endif

    <div class="col-md-4">
        <label>Documento de compra</label>
        <input type="text" name="documento_compra" class="form-control" value="{{ old('documento_compra', $producto->documento_compra ?? '') }}">
    </div>

    <div class="col-md-4">
        <label>Proveedor *</label>
        <select name="proveedor_id" class="form-select" required>
            <option value="">Seleccione...</option>
            @foreach($proveedores as $p)
                <option value="{{ $p->id }}" @selected(old('proveedor_id', $producto->proveedor_id ?? '') == $p->id)>
                    {{ $p->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label>Tipo de Producto *</label>
        <input type="text" name="tipo_producto" class="form-control" required value="{{ old('tipo_producto', $producto->tipo_producto ?? '') }}">
    </div>
    <div class="col-md-6">
        <label>Producto *</label>
        <input type="text" name="producto" class="form-control" required value="{{ old('producto', $producto->producto ?? '') }}">
    </div>
    <div class="col-md-3">
        <label>SKU *</label>
        <input type="text" name="sku" class="form-control" required value="{{ old('sku', $producto->sku ?? '') }}">
    </div>
    <div class="col-md-3">
        <label>No. Serie</label>
        <input type="text" name="numero_serie" class="form-control" value="{{ old('numero_serie', $producto->numero_serie ?? '') }}">
    </div>
    <div class="col-md-3">
        <label>Cantidad *</label>
        <input type="number" name="cantidad" min="0" class="form-control" required value="{{ old('cantidad', $producto->cantidad ?? 0) }}">
    </div>
    <div class="col-md-3">
        <label>Costo Unitario (sin IVA) *</label>
        <input type="number" name="costo_unitario" min="0" step="0.01" class="form-control" required value="{{ old('costo_unitario', $producto->costo_unitario ?? 0) }}">
    </div>
    <div class="col-md-3">
        <label>Precio Venta *</label>
        <input type="number" name="precio_venta" min="0" step="0.01" class="form-control" required value="{{ old('precio_venta', $producto->precio_venta ?? 0) }}">
    </div>
    <div class="col-md-3">
        <label>Precio Mayoreo *</label>
        <input type="number" name="precio_mayoreo" min="0" step="0.01" class="form-control" required value="{{ old('precio_mayoreo', $producto->precio_mayoreo ?? 0) }}">
    </div>
    <div class="col-md-3">
        <label>Costo Total Neto *</label>
        <input type="number" name="costo_total" min="0" step="0.01" class="form-control" required value="{{ old('costo_total', $producto->costo_total ?? 0) }}">
    </div>
</div>
