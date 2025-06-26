@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Detalle de Factura por Pagar</h2>
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Factura: {{ $cuenta->folio_factura }}</span>
            <a href="{{ route('cuentas_por_pagar.edit', $cuenta) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Editar</a>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-4">Proveedor</dt>
                <dd class="col-sm-8">{{ $cuenta->proveedor->nombre ?? '-' }}</dd>
                <dt class="col-sm-4">Monto</dt>
                <dd class="col-sm-8">${{ number_format($cuenta->monto,2) }}</dd>
                <dt class="col-sm-4">Fecha emisión</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</dd>
                <dt class="col-sm-4">Fecha vencimiento</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($cuenta->fecha_vencimiento)->format('d/m/Y') }}</dd>
                <dt class="col-sm-4">Saldo pendiente</dt>
                <dd class="col-sm-8">${{ number_format($cuenta->saldo_pendiente,2) }}</dd>
                <dt class="col-sm-4">Estatus</dt>
                <dd class="col-sm-8">{{ ucfirst($cuenta->estatus) }}</dd>
                <dt class="col-sm-4">XML</dt>
                <dd class="col-sm-8">
                    @if($cuenta->xml_path)
                        <a href="{{ asset('storage/'.$cuenta->xml_path) }}" target="_blank">Descargar</a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </dd>
                <dt class="col-sm-4">PDF</dt>
                <dd class="col-sm-8">
                    @if($cuenta->pdf_path)
                        <a href="{{ asset('storage/'.$cuenta->pdf_path) }}" target="_blank">Descargar</a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </dd>
                <dt class="col-sm-4">Comentarios</dt>
                <dd class="col-sm-8">{{ $cuenta->comentarios ?? '-' }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <form method="POST" action="{{ route('cuentas_por_pagar.destroy', $cuenta) }}" style="display:inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar factura?')">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('cuentas_por_pagar.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <b>Pagos Realizados</b>
            <a href="{{ route('pagos_cxp.create', $cuenta->id) }}" class="btn btn-success btn-sm float-end">
                <i class="bi bi-plus"></i> Registrar Pago
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Comprobante</th>
                        <th>Comentarios</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cuenta->pagos as $pago)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                            <td>${{ number_format($pago->monto,2) }}</td>
                            <td>
                                @if($pago->comprobante_path)
                                    <a href="{{ asset('storage/'.$pago->comprobante_path) }}" target="_blank">Ver archivo</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $pago->comentarios }}</td>
                            <td>
                                <form method="POST" action="{{ route('pagos_cxp.destroy', $pago) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar pago?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No hay pagos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <b>Seguimientos</b>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Comentario</th>
                        <th>Tipo</th>
                        <th>Impacto (%)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cuenta->seguimientos as $seg)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($seg->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $seg->comentario }}</td>
                            <td>{{ $seg->tipo }}</td>
                            <td>{{ $seg->porcentaje_impacto }}</td>
                            <td>
                                <form method="POST" action="{{ route('seguimientos_cxp.destroy', $seg) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar seguimiento?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No hay seguimientos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <form method="POST" action="{{ route('seguimientos_cxp.store') }}" class="p-3">
                @csrf
                <input type="hidden" name="cuenta_pagar_id" value="{{ $cuenta->id }}">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-5 mb-2">
                        <input type="text" name="comentario" class="form-control" placeholder="Comentario">
                    </div>
                    <div class="col-md-2 mb-2">
                        <select name="tipo" class="form-select">
                            <option value="">Tipo</option>
                            <option value="llamada">Llamada</option>
                            <option value="email">Email</option>
                            <option value="reunion">Reunión</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="number" name="porcentaje_impacto" class="form-control" placeholder="Impacto %" min="0" max="100">
                    </div>
                </div>
                <button class="btn btn-primary btn-sm mt-2">Agregar Seguimiento</button>
            </form>
        </div>
    </div>
</div>
@endsection
