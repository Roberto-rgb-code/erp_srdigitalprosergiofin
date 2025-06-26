@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Detalle de Pago</h2>
    <div class="card mb-3">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Monto</dt>
                <dd class="col-sm-8">${{ number_format($pago->monto,2) }}</dd>
                <dt class="col-sm-4">Fecha de pago</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</dd>
                <dt class="col-sm-4">Comprobante</dt>
                <dd class="col-sm-8">
                    @if($pago->comprobante_path)
                        <a href="{{ asset('storage/'.$pago->comprobante_path) }}" target="_blank">Ver archivo</a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </dd>
                <dt class="col-sm-4">Comentarios</dt>
                <dd class="col-sm-8">{{ $pago->comentarios }}</dd>
            </dl>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('cuentas_por_pagar.show', $pago->cuenta_pagar_id) }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>
</div>
@endsection
