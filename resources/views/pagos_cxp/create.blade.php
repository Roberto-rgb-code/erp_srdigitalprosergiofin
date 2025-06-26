@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Registrar Pago</h2>
    <form method="POST" action="{{ route('pagos_cxp.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="cuenta_pagar_id" value="{{ $cuenta_pagar->id }}">
        <div class="mb-3">
            <label>Monto pagado <span class="text-danger">*</span></label>
            <input type="number" name="monto" step="0.01" class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto') }}" required>
            @error('monto') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Fecha de pago</label>
            <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', date('Y-m-d')) }}">
        </div>
        <div class="mb-3">
            <label>Comprobante (PDF, imagen)</label>
            <input type="file" name="comprobante_path" class="form-control">
        </div>
        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
        </div>
        <button class="btn btn-success">Registrar</button>
        <a href="{{ route('cuentas_por_pagar.show', $cuenta_pagar) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
