@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Editar Proveedor</h2>
    <form method="POST" action="{{ route('proveedores.update', $proveedor) }}">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nombre <span class="text-danger">*</span></label>
                <input name="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $proveedor->nombre) }}" required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Ejecutivo de venta</label>
                <input name="ejecutivo_venta" type="text" class="form-control" value="{{ old('ejecutivo_venta', $proveedor->ejecutivo_venta) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Teléfono</label>
                <input name="telefono" type="text" class="form-control" value="{{ old('telefono', $proveedor->telefono) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Dirección</label>
                <input name="direccion" type="text" class="form-control" value="{{ old('direccion', $proveedor->direccion) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Línea de crédito</label>
                <input name="linea_credito" type="number" step="0.01" class="form-control" value="{{ old('linea_credito', $proveedor->linea_credito) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Tiempo de crédito (días)</label>
                <input name="tiempo_credito" type="number" class="form-control" value="{{ old('tiempo_credito', $proveedor->tiempo_credito) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Métodos de entrega</label>
                <input name="metodos_entrega" type="text" class="form-control" value="{{ old('metodos_entrega', $proveedor->metodos_entrega) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Categoría</label>
                <input name="categoria" type="text" class="form-control" value="{{ old('categoria', $proveedor->categoria) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Tipo de proveedor</label>
                <select name="tipo" class="form-select">
                    <option value="">Seleccione...</option>
                    <option value="mayorista" @selected(old('tipo', $proveedor->tipo)=='mayorista')>Mayorista</option>
                    <option value="menudeo" @selected(old('tipo', $proveedor->tipo)=='menudeo')>Menudeo</option>
                    <option value="mayore-menudeo" @selected(old('tipo', $proveedor->tipo)=='mayore-menudeo')>Mayore-menudeo</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label>Método de pago</label>
                <select name="metodo_pago" class="form-select">
                    <option value="">Seleccione...</option>
                    <option value="transferencia" @selected(old('metodo_pago', $proveedor->metodo_pago)=='transferencia')>Transferencia</option>
                    <option value="efectivo" @selected(old('metodo_pago', $proveedor->metodo_pago)=='efectivo')>Efectivo</option>
                    <option value="linea_credito" @selected(old('metodo_pago', $proveedor->metodo_pago)=='linea_credito')>Línea de crédito</option>
                    <option value="tarjeta" @selected(old('metodo_pago', $proveedor->metodo_pago)=='tarjeta')>Pago con tarjeta</option>
                </select>
            </div>
            <div class="col-md-4 mb-3 mt-4 d-flex align-items-center">
                <div class="form-check">
                    <input type="checkbox" name="factura" value="1" class="form-check-input" id="facturaCheck" {{ old('factura', $proveedor->factura) ? 'checked' : '' }}>
                    <label for="facturaCheck" class="form-check-label">¿Factura?</label>
                </div>
            </div>
            <div class="col-12 mb-3">
                <label>Comentarios</label>
                <textarea name="comentarios" class="form-control">{{ old('comentarios', $proveedor->comentarios) }}</textarea>
            </div>
        </div>
        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
