@extends('layouts.app')
@section('content')
<div class="card mt-4">
    <div class="card-header">Registrar movimiento de caja</div>
    <div class="card-body">
        <form method="POST" action="{{ route('punto_venta.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Tipo</label>
                <select name="tipo" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="entrada" @selected(old('tipo')=='entrada')>Entrada</option>
                    <option value="salida" @selected(old('tipo')=='salida')>Salida</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Monto</label>
                <input type="number" name="monto" step="0.01" min="0.01" class="form-control" required value="{{ old('monto') }}">
            </div>
            <div class="mb-3">
                <label>Descripción</label>
                <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion') }}">
            </div>
            <div class="mb-3">
                <label>Fecha</label>
                <input type="date" name="fecha" class="form-control" required value="{{ old('fecha', date('Y-m-d')) }}">
            </div>
            <div class="mb-3">
                <label>Comprobante (opcional)</label>
                <input type="file" name="comprobante" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <button class="btn btn-success">Guardar</button>
            <a href="{{ route('punto_venta.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
