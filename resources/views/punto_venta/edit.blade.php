@extends('layouts.app')
@section('content')
<div class="card mt-4">
    <div class="card-header">Editar movimiento de caja</div>
    <div class="card-body">
        <form method="POST" action="{{ route('punto_venta.update', ['punto_ventum' => $punto_ventum->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Tipo</label>
                <select name="tipo" class="form-select" required>
                    <option value="entrada" @selected(old('tipo', $punto_ventum->tipo)=='entrada')>Entrada</option>
                    <option value="salida" @selected(old('tipo', $punto_ventum->tipo)=='salida')>Salida</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Monto</label>
                <input type="number" name="monto" step="0.01" min="0.01" class="form-control" required value="{{ old('monto', $punto_ventum->monto) }}">
            </div>
            <div class="mb-3">
                <label>Descripción</label>
                <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $punto_ventum->descripcion) }}">
            </div>
            <div class="mb-3">
                <label>Fecha</label>
                <input type="date" name="fecha" class="form-control" required value="{{ old('fecha', $punto_ventum->fecha) }}">
            </div>
            <div class="mb-3">
                <label>Comprobante (PDF, JPG, PNG; máx 4MB)</label>
                @if($punto_ventum->comprobante)
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$punto_ventum->comprobante) }}" target="_blank">Ver archivo actual</a>
                    </div>
                @endif
                <input type="file" name="comprobante" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Dejar vacío si no deseas reemplazar el comprobante.</small>
            </div>
            <button class="btn btn-success">Actualizar movimiento</button>
            <a href="{{ route('punto_venta.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
