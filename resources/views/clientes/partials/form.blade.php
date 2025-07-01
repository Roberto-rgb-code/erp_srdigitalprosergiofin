{{-- Mensajes de error --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="nombre_completo" class="form-label">Nombre completo *</label>
    <input
        type="text"
        class="form-control @error('nombre_completo') is-invalid @enderror"
        id="nombre_completo"
        name="nombre_completo"
        value="{{ old('nombre_completo', $cliente->nombre_completo ?? '') }}"
        required>
    @error('nombre_completo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="empresa" class="form-label">Empresa (opcional)</label>
    <input
        type="text"
        class="form-control @error('empresa') is-invalid @enderror"
        id="empresa"
        name="empresa"
        value="{{ old('empresa', $cliente->empresa ?? '') }}">
    @error('empresa')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="tipo_cliente" class="form-label">Tipo de Cliente *</label>
    <select
        name="tipo_cliente"
        id="tipo_cliente"
        class="form-select @error('tipo_cliente') is-invalid @enderror"
        required>
        <option value="">Selecciona...</option>
        <option value="Usuario final" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? '') == 'Usuario final')>Usuario final</option>
        <option value="Empresa" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? '') == 'Empresa')>Empresa</option>
        <option value="Mayorista" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? '') == 'Mayorista')>Mayorista</option>
    </select>
    @error('tipo_cliente')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="contacto" class="form-label">Teléfono / WhatsApp</label>
    <input
        type="text"
        class="form-control @error('contacto') is-invalid @enderror"
        id="contacto"
        name="contacto"
        value="{{ old('contacto', $cliente->contacto ?? '') }}">
    @error('contacto')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <input
        type="text"
        class="form-control @error('direccion') is-invalid @enderror"
        id="direccion"
        name="direccion"
        value="{{ old('direccion', $cliente->direccion ?? '') }}">
    @error('direccion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<hr>
<h5 class="mb-2">Datos fiscales (opcional)</h5>

<div class="mb-3">
    <label for="nombre_fiscal" class="form-label">Nombre fiscal</label>
    <input
        type="text"
        class="form-control @error('nombre_fiscal') is-invalid @enderror"
        id="nombre_fiscal"
        name="nombre_fiscal"
        value="{{ old('nombre_fiscal', $cliente->datoFiscal->nombre_fiscal ?? '') }}">
    @error('nombre_fiscal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="rfc" class="form-label">RFC</label>
    <input
        type="text"
        class="form-control @error('rfc') is-invalid @enderror"
        id="rfc"
        name="rfc"
        value="{{ old('rfc', $cliente->datoFiscal->rfc ?? '') }}">
    @error('rfc')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="direccion_fiscal" class="form-label">Dirección fiscal</label>
    <input
        type="text"
        class="form-control @error('direccion_fiscal') is-invalid @enderror"
        id="direccion_fiscal"
        name="direccion_fiscal"
        value="{{ old('direccion_fiscal', $cliente->datoFiscal->direccion_fiscal ?? '') }}">
    @error('direccion_fiscal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="uso_cfdi" class="form-label">Uso de CFDI</label>
    <input
        type="text"
        class="form-control @error('uso_cfdi') is-invalid @enderror"
        id="uso_cfdi"
        name="uso_cfdi"
        value="{{ old('uso_cfdi', $cliente->datoFiscal->uso_cfdi ?? '') }}">
    @error('uso_cfdi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="correo" class="form-label">Correo electrónico</label>
    <input
        type="email"
        class="form-control @error('correo') is-invalid @enderror"
        id="correo"
        name="correo"
        value="{{ old('correo', $cliente->datoFiscal->correo ?? '') }}">
    @error('correo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="regimen_fiscal" class="form-label">Régimen fiscal</label>
    <input
        type="text"
        class="form-control @error('regimen_fiscal') is-invalid @enderror"
        id="regimen_fiscal"
        name="regimen_fiscal"
        value="{{ old('regimen_fiscal', $cliente->datoFiscal->regimen_fiscal ?? '') }}">
    @error('regimen_fiscal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
