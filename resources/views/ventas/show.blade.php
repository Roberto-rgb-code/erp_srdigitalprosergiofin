@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4 mb-4">
        <div class="card-body">
            <h3 class="mb-3">
                <i class="bi bi-receipt"></i> Venta: <span class="badge bg-primary">{{ $venta->folio }}</span>
            </h3>
            <dl class="row">
                <dt class="col-sm-3">Cliente</dt>
                <dd class="col-sm-9">{{ $venta->cliente->nombre_completo ?? '-' }}</dd>

                <dt class="col-sm-3">Fecha de Venta</dt>
                <dd class="col-sm-9">{{ $venta->fecha_venta }}</dd>

                <dt class="col-sm-3">Monto Total</dt>
                <dd class="col-sm-9"><strong>${{ number_format($venta->monto_total,2) }}</strong></dd>

                <dt class="col-sm-3">Estatus</dt>
                <dd class="col-sm-9">
                    <span class="badge bg-{{ $venta->estatus == 'Pagado' ? 'success' : ($venta->estatus == 'Cancelado' ? 'danger' : 'warning') }}">
                        {{ $venta->estatus ?? '-' }}
                    </span>
                </dd>

                <dt class="col-sm-3">Tipo de Venta</dt>
                <dd class="col-sm-9">{{ $venta->tipo_venta ?? '-' }}</dd>

                <dt class="col-sm-3">Comentarios</dt>
                <dd class="col-sm-9">{{ $venta->comentarios ?? '-' }}</dd>
            </dl>
        </div>
    </div>

    <div class="card shadow rounded-4 mb-4">
        <div class="card-header bg-light fw-bold">Productos / Servicios</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>No. Serie</th>
                        <th>Producto/Servicio</th>
                        <th>Precio Costo</th>
                        <th>Precio Venta</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($venta->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->sku ?? '-' }}</td>
                            <td>{{ $detalle->no_serie ?? '-' }}</td>
                            <td>{{ $detalle->nombre_producto ?? ($detalle->producto->nombre ?? '-') }}</td>
                            <td>${{ number_format($detalle->precio_costo,2) }}</td>
                            <td>${{ number_format($detalle->precio_venta,2) }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->subtotal,2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($venta->pagos && $venta->pagos->count())
    <div class="card shadow rounded-4 mb-4">
        <div class="card-header bg-light fw-bold">Pagos</div>
        <div class="card-body p-0">
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Método</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->pagos as $pago)
                        <tr>
                            <td>${{ number_format($pago->monto,2) }}</td>
                            <td>{{ $pago->fecha ?? '-' }}</td>
                            <td>{{ $pago->metodo_pago ?? '-' }}</td>
                            <td>{{ $pago->comentarios ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="d-flex gap-2">
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary rounded-pill">Volver</a>
        <a href="{{ route('ventas.nota', $venta) }}" class="btn btn-outline-danger rounded-pill" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Descargar Nota de Venta PDF
        </a>
        <button class="btn btn-outline-success rounded-pill" onclick="alert('Próximamente: integración con SAT para factura timbrada');" type="button">
            <i class="bi bi-file-earmark-medical"></i> Generar Factura (SAT)
        </button>
    </div>
</div>
@endsection
