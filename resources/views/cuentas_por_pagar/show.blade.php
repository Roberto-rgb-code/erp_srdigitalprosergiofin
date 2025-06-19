@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle Cuenta por Pagar</h2>

    <div class="card shadow rounded-4 p-4 mb-3">
        <div class="mb-2">
            <strong>Proveedor:</strong> {{ $cuenta->proveedor->nombre ?? '-' }}
        </div>
        <div class="mb-2">
            <strong>Factura:</strong> {{ $cuenta->folio_factura }}
        </div>
        <div class="mb-2">
            <strong>Fecha de Emisión:</strong> {{ $cuenta->fecha_emision }}
        </div>
        <div class="mb-2">
            <strong>Fecha de Vencimiento:</strong> {{ $cuenta->fecha_vencimiento }}
        </div>
        <div class="mb-2">
            <strong>Monto Total:</strong> ${{ number_format($cuenta->monto_total, 2) }}
        </div>
        <div class="mb-2">
            <strong>Saldo Pendiente:</strong> ${{ number_format($cuenta->saldo_pendiente, 2) }}
        </div>
        <div class="mb-2">
            <strong>Estatus:</strong> {{ $cuenta->estatus }}
        </div>
        <div class="mb-2">
            <strong>XML:</strong>
            @if($cuenta->xml)
                <a href="{{ Storage::url($cuenta->xml) }}" target="_blank">Ver XML</a>
            @endif
        </div>
        <div class="mb-2">
            <strong>PDF:</strong>
            @if($cuenta->pdf)
                <a href="{{ Storage::url($cuenta->pdf) }}" target="_blank">Ver PDF</a>
            @endif
        </div>
        <div>
            <a href="{{ route('cuentas_por_pagar.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>
    </div>
</div>
@endsection
