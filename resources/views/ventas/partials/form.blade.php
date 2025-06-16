<div class="mb-3">
    <label>Cliente *</label>
    <select name="cliente_id" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach($clientes as $c)
            <option value="{{ $c->id }}" @selected(old('cliente_id', $venta->cliente_id ?? '') == $c->id)>{{ $c->nombre }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Fecha de Venta *</label>
    <input type="date" name="fecha_venta" value="{{ old('fecha_venta', $venta->fecha_venta ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Monto Total *</label>
    <input type="number" step="0.01" name="monto_total" value="{{ old('monto_total', $venta->monto_total ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Estatus</label>
    <input type="text" name="estatus" value="{{ old('estatus', $venta->estatus ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Tipo de Venta</label>
    <input type="text" name="tipo_venta" value="{{ old('tipo_venta', $venta->tipo_venta ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Comentarios</label>
    <textarea name="comentarios" class="form-control">{{ old('comentarios', $venta->comentarios ?? '') }}</textarea>
</div>
