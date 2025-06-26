@extends('layouts.app')
@section('content')
<div class="card mt-4">
    <div class="card-header">Detalle de Compra</div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-4">Proveedor</dt>
            <dd class="col-sm-8">{{ $compra->proveedor }}</dd>
            <dt class="col-sm-4">Descripción</dt>
            <dd class="col-sm-8">{{ $compra->descripcion }}</dd>
            <dt class="col-sm-4">Monto</dt>
            <dd class="col-sm-8">${{ number_format($compra->monto,2) }}</dd>
            <dt class="col-sm-4">Fecha de compra</dt>
            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</dd>
            <dt class="col-sm-4">Método de pago</dt>
            <dd class="col-sm-8">{{ ucfirst($compra->metodo_pago) }}</dd>
            <dt class="col-sm-4">Factura</dt>
            <dd class="col-sm-8">{{ $compra->factura ? 'Sí' : 'No' }}</dd>
            <dt class="col-sm-4">Comentarios</dt>
            <dd class="col-sm-8">{{ $compra->comentarios }}</dd>
        </dl>
        <a href="{{ route('compras.edit', $compra) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('compras.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
