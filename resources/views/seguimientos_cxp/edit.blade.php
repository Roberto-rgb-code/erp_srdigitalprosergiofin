@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Editar Seguimiento</h2>
    <form method="POST" action="{{ route('seguimientos_cxp.update', $seguimiento) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $seguimiento->fecha) }}">
        </div>
        <div class="mb-3">
            <label>Comentario</label>
            <input type="text" name="comentario" class="form-control" value="{{ old('comentario', $seguimiento->comentario) }}">
        </div>
        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-select">
                <option value="">Seleccione...</option>
                <option value="llamada" @selected($seguimiento->tipo == 'llamada')>Llamada</option>
                <option value="email" @selected($seguimiento->tipo == 'email')>Email</option>
                <option value="reunion" @selected($seguimiento->tipo == 'reunion')>Reunión</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Porcentaje de Impacto</label>
            <input type="number" name="porcentaje_impacto" class="form-control" value="{{ old('porcentaje_impacto', $seguimiento->porcentaje_impacto) }}" min="0" max="100">
        </div>
        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('cuentas_por_pagar.show', $seguimiento->cuenta_pagar_id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
