@extends('layouts.app')
@section('content')
<div class="container py-4">
    {{-- Encabezado y acción principal --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
        <h2 class="mb-0 fw-bold">
            <i class="bi bi-cash-stack me-2"></i> Ventas
        </h2>
        <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-lg shadow-sm rounded-pill">
            <i class="bi bi-plus-lg"></i> Nueva Venta
        </a>
    </div>

    {{-- Mensajes flash --}}
    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info mb-3">{{ session('info') }}</div>
    @endif

    {{-- Resúmenes --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <div class="fs-1 fw-bold text-primary mb-1">
                        ${{ number_format($ventas->sum('monto_total'), 2) }}
                    </div>
                    <div class="text-muted small">Monto total (página actual)</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <div class="fs-1 fw-bold text-success mb-1">
                        {{ $ventas->total() }}
                    </div>
                    <div class="text-muted small">Ventas totales (paginado)</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <div class="fs-1 fw-bold text-info mb-1">
                        {{ $clientes->count() }}
                    </div>
                    <div class="text-muted small">Clientes registrados</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <form class="row g-2 align-items-end mb-4" method="GET">
        <div class="col-md-2">
            <label class="form-label mb-1">Cliente</label>
            <select name="cliente_id" class="form-select">
                <option value="">Todos</option>
                @foreach($clientes as $cl)
                    <option value="{{ $cl->id }}" @selected(request('cliente_id') == $cl->id)>{{ $cl->nombre_completo }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label mb-1">Fecha</label>
            <input type="date" name="fecha_venta" class="form-control" value="{{ request('fecha_venta') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label mb-1">Tipo de venta</label>
            <input type="text" name="tipo_venta" class="form-control" placeholder="Tipo de venta" value="{{ request('tipo_venta') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label mb-1">Estatus</label>
            <select name="estatus" class="form-select">
                <option value="">Todos</option>
                <option value="Pagado" @selected(request('estatus')=='Pagado')>Pagado</option>
                <option value="Pendiente" @selected(request('estatus')=='Pendiente')>Pendiente</option>
                <option value="Cancelado" @selected(request('estatus')=='Cancelado')>Cancelado</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-secondary flex-grow-1"><i class="bi bi-search"></i> Buscar</button>
            <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            <a href="{{ route('ventas.export.excel', request()->all()) }}" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Excel</a>
            <a href="{{ route('ventas.export.pdf', request()->all()) }}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
        </div>
    </form>

    {{-- Gráficos --}}
    <div class="row mb-5 g-3">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-bold">Ventas por Mes</div>
                <div class="card-body">
                    <canvas id="ventasPorMes" height="140"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-bold">Ventas por Estatus</div>
                <div class="card-body">
                    <canvas id="ventasPorEstatus" height="140"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Ventas --}}
    <div class="table-responsive shadow-sm rounded mb-5">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr class="align-middle text-center">
                    <th>Folio</th>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Monto Total</th>
                    <th>Estatus</th>
                    <th>Tipo</th>
                    <th style="min-width:160px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $v)
                    <tr>
                        <td class="text-center">{{ $v->folio ?? '-' }}</td>
                        <td class="text-center">{{ $v->id }}</td>
                        <td>{{ $v->cliente->nombre_completo ?? '-' }}</td>
                        <td class="text-center">{{ $v->fecha_venta }}</td>
                        <td class="fw-bold text-end">${{ number_format($v->monto_total,2) }}</td>
                        <td class="text-center">
                            @if($v->estatus === 'Pagado')
                                <span class="badge bg-success">Pagado</span>
                            @elseif($v->estatus === 'Pendiente')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @elseif($v->estatus === 'Cancelado')
                                <span class="badge bg-danger">Cancelado</span>
                            @else
                                <span class="badge bg-secondary">{{ $v->estatus }}</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $v->tipo_venta }}</td>
                        <td class="text-center">
                            <a href="{{ route('ventas.show', $v) }}" class="btn btn-sm btn-info mb-1" title="Ver detalles"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('ventas.edit', $v) }}" class="btn btn-sm btn-warning mb-1" title="Editar"><i class="bi bi-pencil"></i></a>
                            <a href="{{ route('ventas.nota', $v) }}" class="btn btn-sm btn-outline-danger mb-1" target="_blank" title="Nota de Venta PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                            <a href="{{ route('ventas.factura', $v) }}" class="btn btn-sm btn-outline-primary mb-1" target="_blank" title="Factura PDF">
                                <i class="bi bi-file-earmark-medical"></i>
                            </a>
                            <form action="{{ route('ventas.destroy', $v) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No hay ventas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $ventas->links() }}
        </div>
    </div>

    {{-- Top Clientes --}}
    <div class="my-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Top 5 Clientes por monto vendido</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Monto Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topClientes as $tc)
                            <tr>
                                <td>{{ $tc->cliente->nombre_completo ?? '-' }}</td>
                                <td class="fw-bold">${{ number_format($tc->total,2) }}</td>
                            </tr>
                        @endforeach
                        @if($topClientes->isEmpty())
                            <tr><td colspan="2">Sin datos.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(isset($ventasPorMes) && count($ventasPorMes))
    const ctxMes = document.getElementById('ventasPorMes').getContext('2d');
    new Chart(ctxMes, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($ventasPorMes)) !!},
            datasets: [{
                label: 'Monto vendido',
                data: {!! json_encode(array_values($ventasPorMes)) !!},
                backgroundColor: 'rgba(13, 110, 253, 0.6)',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
@endif

@if(isset($ventasPorEstatus) && count($ventasPorEstatus))
    const ctxEst = document.getElementById('ventasPorEstatus').getContext('2d');
    new Chart(ctxEst, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($ventasPorEstatus)) !!},
            datasets: [{
                label: 'Ventas por Estatus',
                data: {!! json_encode(array_values($ventasPorEstatus)) !!},
                backgroundColor: [
                    '#198754', // verde
                    '#ffc107', // amarillo
                    '#dc3545', // rojo
                    '#0dcaf0', // azul
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
@endif
</script>
@endpush
