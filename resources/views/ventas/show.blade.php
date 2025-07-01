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

            {{-- Sección: Productos vendidos --}}
            <h5 class="mt-4 mb-3"><i class="bi bi-box-seam"></i> Productos vendidos</h5>
            @if($venta->productos && $venta->productos->count())
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>SKU</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($venta->productos as $prod)
                        <tr>
                            <td>{{ $prod->producto }}</td>
                            <td>{{ $prod->sku }}</td>
                            <td class="text-center">{{ $prod->pivot->cantidad }}</td>
                            <td>${{ number_format($prod->pivot->precio_unitario,2) }}</td>
                            <td>
                                ${{ number_format($prod->pivot->cantidad * $prod->pivot->precio_unitario,2) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total de venta:</th>
                            <th>
                                ${{ number_format($venta->productos->sum(function($prod){
                                    return $prod->pivot->cantidad * $prod->pivot->precio_unitario;
                                }),2) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
                <div class="alert alert-warning">No hay productos registrados en esta venta.</div>
            @endif

            {{-- Datos fiscales del cliente --}}
            @php
                $datoFiscal = $venta->cliente->datoFiscal ?? null;
            @endphp
            @if($datoFiscal)
            <div class="alert alert-info mb-4">
                <div class="fw-bold mb-2">
                    <i class="bi bi-file-earmark-text"></i> Datos fiscales del cliente
                </div>
                <ul class="mb-0 ps-3">
                    <li><strong>Nombre fiscal:</strong> {{ $datoFiscal->nombre_fiscal ?? '-' }}</li>
                    <li><strong>RFC:</strong> {{ $datoFiscal->rfc ?? '-' }}</li>
                    <li><strong>Dirección fiscal:</strong> {{ $datoFiscal->direccion_fiscal ?? '-' }}</li>
                    <li><strong>Correo:</strong> {{ $datoFiscal->correo ?? '-' }}</li>
                    <li><strong>Uso CFDI:</strong> {{ $datoFiscal->uso_cfdi ?? '-' }}</li>
                    <li><strong>Régimen fiscal:</strong> {{ $datoFiscal->regimen_fiscal ?? '-' }}</li>
                </ul>
            </div>
            @endif
        </div>
    </div>

    {{-- Pagos --}}
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
