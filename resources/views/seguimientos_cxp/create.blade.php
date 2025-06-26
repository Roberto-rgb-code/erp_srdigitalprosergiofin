@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Agregar Seguimiento</h2>
    <form method="POST" action="{{ route('seguimientos_cxp.store') }}">
        @csrf
        <input type="hidden" name="cuenta_pagar_id" value="{{ $cuenta_pagar->id }}">
        <div class="mb-3">
            <label>Fecha <span class="text-danger">*</span></label>
            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', date('Y-m-d')) }}" required>
            @error('fecha') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Comentario</label>
            <input type="text" name="comentario" class="form-control" value="{{ old('comentario') }}">
        </div>
        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-select">
                <option value="">Seleccione...</option>
                <option value="llamada">Llamada</option>
                <option value="email">Email</option>
                <option value="reunion">Reunión</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Porcentaje de Impacto</label>
            <input type="number" name="porcentaje_impacto" class="form-control" value="{{ old('porcentaje_impacto') }}" min="0" max="100">
        </div>
        <button class="btn btn-success">Agregar</button>
        <a href="{{ route('cuentas_por_pagar.show', $cuenta_pagar) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
