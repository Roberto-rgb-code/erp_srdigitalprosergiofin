<div class="mb-3">
    <label for="nombre" class="form-label">Nombre completo / Empresa *</label>
    <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="tipo_cliente" class="form-label">Tipo de Cliente *</label>
    <select name="tipo_cliente" id="tipo_cliente" class="form-select" required>
        <option value="">Selecciona...</option>
        <option value="Usuario final" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? '') == 'Usuario final')>Usuario final</option>
        <option value="Autoempleado" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? '') == 'Autoempleado')>Autoempleado</option>
        <option value="Empresa" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? '') == 'Empresa')>Empresa</option>
    </select>
</div>
<div class="mb-3">
    <label for="contacto" class="form-label">Teléfono / WhatsApp</label>
    <input type="text" class="form-control" name="contacto" id="contacto" value="{{ old('contacto', $cliente->contacto ?? '') }}">
</div>
<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" class="form-control" name="direccion" id="direccion" value="{{ old('direccion', $cliente->direccion ?? '') }}">
</div>
<div class="mb-3">
    <label for="requiere_factura" class="form-label">¿Requiere factura?</label>
    <input type="checkbox" name="requiere_factura" id="requiere_factura" value="1" {{ old('requiere_factura', $cliente->requiere_factura ?? 0) ? 'checked' : '' }}>
</div>
<div class="mb-3">
    <label for="rfc" class="form-label">RFC</label>
    <input type="text" class="form-control" name="rfc" id="rfc" value="{{ old('rfc', $cliente->rfc ?? '') }}">
</div>
<div class="mb-3">
    <label for="limite_credito" class="form-label">Límite de crédito</label>
    <input type="number" step="0.01" class="form-control" name="limite_credito" id="limite_credito" value="{{ old('limite_credito', $cliente->limite_credito ?? 0) }}">
</div>
<div class="mb-3">
    <label for="saldo" class="form-label">Saldo</label>
    <input type="number" step="0.01" class="form-control" name="saldo" id="saldo" value="{{ old('saldo', $cliente->saldo ?? 0) }}">
</div>
<div class="mb-3">
    <label for="tiene_linea_credito" class="form-label">¿Tiene línea de crédito?</label>
    <input type="checkbox" name="tiene_linea_credito" id="tiene_linea_credito" value="1" {{ old('tiene_linea_credito', $cliente->tiene_linea_credito ?? 0) ? 'checked' : '' }}>
</div>
<div class="mb-3">
    <label for="status" class="form-label">Estatus</label>
    <select name="status" id="status" class="form-select">
        <option value="Activo" @selected(old('status', $cliente->status ?? '') == 'Activo')>Activo</option>
        <option value="Inactivo" @selected(old('status', $cliente->status ?? '') == 'Inactivo')>Inactivo</option>
    </select>
</div>
