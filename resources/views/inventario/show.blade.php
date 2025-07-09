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

            @if($inventario->stockUnits && $inventario->stockUnits->count())
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#stockModal">
                    Ver Stock Detallado ({{ $inventario->stockUnits->count() }})
                </button>
            @endif

            <div class="d-flex gap-2">
                <a href="{{ route('inventario.index') }}" class="btn btn-secondary rounded-pill">Volver</a>
                <a href="{{ route('inventario.edit', ['inventario' => $inventario->id]) }}" class="btn btn-warning rounded-pill">Editar</a>
            </div>
        </div>
    </div>
</div>

{{-- Modal para mostrar unidades de stock --}}
@if($inventario->stockUnits && $inventario->stockUnits->count())
<div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title" id="stockModalLabel">Stock y Números de Serie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Número de Serie</th>
              <th>Código de Barras</th>
            </tr>
          </thead>
          <tbody>
            @foreach($inventario->stockUnits as $i => $unit)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $unit->numero_serie ?? '-' }}</td>
              <td>
                @if($unit->numero_serie)
                  <a href="{{ route('inventario.export.etiqueta', $unit->id) }}" target="_blank" title="Descargar etiqueta PDF">
                    <img src="https://api-bwipjs.metafloor.com/?bcid=code128&text={{ urlencode($unit->numero_serie) }}&includetext" height="50">
                  </a>
                  <div><small>Click para descargar</small></div>
                @else
                  -
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

@endsection
