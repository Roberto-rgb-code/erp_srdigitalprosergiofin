@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4 mb-4">
        <div class="card-body">
            <h3 class="mb-3">
                <i class="bi bi-box"></i> Producto: <span class="badge bg-primary">{{ $inventario->sku }}</span>
            </h3>
            <dl class="row">
                <dt class="col-sm-4">Folio Compra</dt>
                <dd class="col-sm-8">{{ $inventario->folio }}</dd>

                <dt class="col-sm-4">Proveedor</dt>
                <dd class="col-sm-8">{{ $inventario->proveedor->nombre ?? '-' }}</dd>

                <dt class="col-sm-4">Tipo de Producto</dt>
                <dd class="col-sm-8">{{ $inventario->tipo_producto }}</dd>

                <dt class="col-sm-4">Producto</dt>
                <dd class="col-sm-8">{{ $inventario->producto }}</dd>

                <dt class="col-sm-4">No. Serie</dt>
                <dd class="col-sm-8">{{ $inventario->numero_serie ?? '-' }}</dd>

                <dt class="col-sm-4">Cantidad</dt>
                <dd class="col-sm-8">{{ $inventario->cantidad }}</dd>

                <dt class="col-sm-4">Costo Unitario</dt>
                <dd class="col-sm-8">${{ number_format($inventario->costo_unitario, 2) }}</dd>

                <dt class="col-sm-4">Precio Venta</dt>
                <dd class="col-sm-8">${{ number_format($inventario->precio_venta, 2) }}</dd>

                <dt class="col-sm-4">Precio Mayoreo</dt>
                <dd class="col-sm-8">${{ number_format($inventario->precio_mayoreo, 2) }}</dd>

                <dt class="col-sm-4">Costo Total Neto</dt>
                <dd class="col-sm-8">${{ number_format($inventario->costo_total, 2) }}</dd>
            </dl>
            <div class="d-flex gap-2">
                <a href="{{ route('inventario.index') }}" class="btn btn-secondary rounded-pill">Volver</a>
                <a href="{{ route('inventario.edit', ['inventario' => $inventario->id]) }}" class="btn btn-warning rounded-pill">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
