@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Editar Pago</h2>
    <form method="POST" action="{{ route('pagos_cxp.update', $pago) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Monto pagado <span class="text-danger">*</span></label>
            <input type="number" name="monto" step="0.01" class="form-control" value="{{ old('monto', $pago->monto) }}" required>
        </div>
        <div class="mb-3">
            <label>Fecha de pago</label>
            <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', $pago->fecha_pago) }}">
        </div>
        <div class="mb-3">
            <label>Comprobante (PDF, imagen)</label>
            <input type="file" name="comprobante_path" class="form-control">
            @if($pago->comprobante_path)
                <small>Actual: <a href="{{ asset('storage/'.$pago->comprobante_path) }}" target="_blank">Ver archivo</a></small>
            @endif
        </div>
        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios', $pago->comentarios) }}</textarea>
        </div>
        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('cuentas_por_pagar.show', $pago->cuenta_pagar_id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
