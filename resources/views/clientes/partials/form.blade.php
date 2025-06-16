<div class="mb-3">
    <label>Nombre *</label>
    <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>RFC</label>
    <input type="text" name="rfc" value="{{ old('rfc', $cliente->rfc ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Dirección</label>
    <input type="text" name="direccion" value="{{ old('direccion', $cliente->direccion ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Contacto</label>
    <input type="text" name="contacto" value="{{ old('contacto', $cliente->contacto ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Tipo de Cliente</label>
    <input type="text" name="tipo_cliente" value="{{ old('tipo_cliente', $cliente->tipo_cliente ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Límite de Crédito</label>
    <input type="number" step="0.01" name="limite_credito" value="{{ old('limite_credito', $cliente->limite_credito ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Saldo</label>
    <input type="number" step="0.01" name="saldo" value="{{ old('saldo', $cliente->saldo ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Estatus</label>
    <input type="text" name="status" value="{{ old('status', $cliente->status ?? '') }}" class="form-control">
</div>
