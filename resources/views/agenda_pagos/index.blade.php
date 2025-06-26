@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Agenda de Pagos</h2>

    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="vencidos-tab" data-bs-toggle="tab" href="#vencidos" role="tab">Pagos Vencidos</a></li>
        <li class="nav-item"><a class="nav-link" id="programados-tab" data-bs-toggle="tab" href="#programados" role="tab">Pagos Programados</a></li>
        <li class="nav-item"><a class="nav-link" id="realizados-tab" data-bs-toggle="tab" href="#realizados" role="tab">Pagos Realizados</a></li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Pagos Vencidos -->
        <div class="tab-pane fade show active" id="vencidos" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Factura</th>
                        <th>Monto</th>
                        <th>Vencimiento</th>
                        <th>Saldo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pagos_vencidos as $p)
                    <tr>
                        <td>{{ $p->proveedor->nombre ?? '-' }}</td>
                        <td>{{ $p->folio_factura }}</td>
                        <td>${{ number_format($p->monto,2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->fecha_vencimiento)->format('d/m/Y') }}</td>
                        <td>
                            @if($p->saldo_pendiente > 0)
                                <span class="badge bg-warning">${{ number_format($p->saldo_pendiente,2) }}</span>
                            @else
                                <span class="badge bg-success">Pagada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cuentas_por_pagar.show', $p) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No hay pagos vencidos.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagos Programados -->
        <div class="tab-pane fade" id="programados" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Factura</th>
                        <th>Monto</th>
                        <th>Vencimiento</th>
                        <th>Saldo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pagos_programados as $p)
                    <tr>
                        <td>{{ $p->proveedor->nombre ?? '-' }}</td>
                        <td>{{ $p->folio_factura }}</td>
                        <td>${{ number_format($p->monto,2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->fecha_vencimiento)->format('d/m/Y') }}</td>
                        <td>
                            @if($p->saldo_pendiente > 0)
                                <span class="badge bg-warning">${{ number_format($p->saldo_pendiente,2) }}</span>
                            @else
                                <span class="badge bg-success">Pagada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cuentas_por_pagar.show', $p) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No hay pagos programados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagos Realizados -->
        <div class="tab-pane fade" id="realizados" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Factura</th>
                        <th>Monto</th>
                        <th>Fecha de Pago</th>
                        <th>Comprobante</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pagos_realizados as $pr)
                    <tr>
                        <td>{{ $pr->cuenta->proveedor->nombre ?? '-' }}</td>
                        <td>{{ $pr->cuenta->folio_factura ?? '-' }}</td>
                        <td>${{ number_format($pr->monto,2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($pr->fecha_pago)->format('d/m/Y') }}</td>
                        <td>
                            @if($pr->comprobante_path)
                                <a href="{{ asset('storage/'.$pr->comprobante_path) }}" target="_blank">Ver archivo</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No hay pagos realizados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
