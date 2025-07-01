@extends('layouts.app')
@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <h2 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i> Inventario</h2>
        <div>
            <a href="{{ route('inventario.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Producto
            </a>
        </div>
    </div>

    {{-- Métricas rápidas --}}
    <div class="row mb-4 g-3">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body">
                    <div class="fs-3 text-primary"><i class="bi bi-archive"></i></div>
                    <div class="fw-bold fs-5">{{ $productos->total() }}</div>
                    <small class="text-uppercase text-secondary">Productos registrados</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body">
                    <div class="fs-3 text-success"><i class="bi bi-truck"></i></div>
                    <div class="fw-bold fs-5">{{ $proveedores->count() }}</div>
                    <small class="text-uppercase text-secondary">Proveedores</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body">
                    <div class="fs-3 text-warning"><i class="bi bi-tags"></i></div>
                    <div class="fw-bold fs-5">{{ $tiposProducto->count() }}</div>
                    <small class="text-uppercase text-secondary">Tipos de producto</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body">
                    <div class="fs-3 text-info"><i class="bi bi-cash-coin"></i></div>
                    <div class="fw-bold fs-5 text-info">
                        ${{ number_format($productos->sum('costo_total'), 2) }}
                    </div>
                    <small class="text-uppercase text-secondary">Total Neto Inventario</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos UX --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-pie-chart-fill me-1"></i> Distribución por tipo de producto
                </div>
                <div class="card-body">
                    <canvas id="graficoTipo" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-graph-up-arrow me-1"></i> Productos por proveedor
                </div>
                <div class="card-body">
                    <canvas id="graficoProveedor" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <form class="row g-2 mb-3 align-items-end" method="GET">
        <div class="col-md-2">
            <label class="form-label mb-1">SKU</label>
            <input type="text" name="sku" class="form-control" placeholder="SKU" value="{{ request('sku') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label mb-1">No. Serie</label>
            <input type="text" name="numero_serie" class="form-control" placeholder="No. Serie" value="{{ request('numero_serie') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label mb-1">Proveedor</label>
            <select name="proveedor_id" class="form-select">
                <option value="">Todos</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id }}" @selected(request('proveedor_id') == $prov->id)>{{ $prov->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label mb-1">Tipo de Producto</label>
            <select name="tipo_producto" class="form-select">
                <option value="">Todos</option>
                @foreach($tiposProducto as $tipo)
                    <option value="{{ $tipo }}" @selected(request('tipo_producto') == $tipo)>{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-primary"><i class="bi bi-search"></i> Buscar</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('inventario.index') }}" class="btn btn-light border"><i class="bi bi-x-circle"></i> Limpiar</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('inventario.export.excel', request()->all()) }}" class="btn btn-success shadow-sm">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </a>
            <a href="{{ route('inventario.export.pdf', request()->all()) }}" class="btn btn-danger shadow-sm">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </a>
        </div>
    </form>

    {{-- Tabla UX --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Folio</th>
                    <th>SKU</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th class="text-center">Cantidad</th>
                    <th>Proveedor</th>
                    <th>Serie</th>
                    <th>Costo Unitario</th>
                    <th>Precio Venta</th>
                    <th>Precio Mayoreo</th>
                    <th>Total Neto</th>
                    <th style="width:130px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $p)
                <tr>
                    <td class="fw-bold">{{ $p->folio ?? $p->id }}</td>
                    <td>{{ $p->sku }}</td>
                    <td>{{ $p->producto }}</td>
                    <td>{{ $p->tipo_producto }}</td>
                    <td class="fw-bold text-center">{{ $p->cantidad }}</td>
                    <td>
                        @if($p->proveedor)
                            <span class="badge bg-info-subtle text-info">{{ $p->proveedor->nombre }}</span>
                        @else
                            <span class="badge bg-warning text-dark">Sin proveedor</span>
                        @endif
                    </td>
                    <td>{{ $p->numero_serie }}</td>
                    <td>${{ number_format($p->costo_unitario, 2) }}</td>
                    <td>${{ number_format($p->precio_venta, 2) }}</td>
                    <td>${{ number_format($p->precio_mayoreo, 2) }}</td>
                    <td class="fw-bold text-success">${{ number_format($p->costo_total, 2) }}</td>
                    <td>
                        <a href="{{ route('inventario.edit', ['inventario' => $p->id]) }}" class="btn btn-warning btn-sm me-1" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('inventario.destroy', ['inventario' => $p->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('inventario.show', ['inventario' => $p->id]) }}" class="btn btn-info btn-sm" title="Ver">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="12" class="text-center text-secondary">No hay productos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $productos->links() }}</div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Tipos de Producto
    const ctxTipo = document.getElementById('graficoTipo').getContext('2d');
    new Chart(ctxTipo, {
        type: 'pie',
        data: {
            labels: {!! json_encode($conteoTipo->keys()) !!},
            datasets: [{
                data: {!! json_encode($conteoTipo->values()) !!},
                backgroundColor: [
                    '#1976d2', '#43a047', '#fbc02d', '#e53935', '#6d4c41', '#00838f'
                ]
            }]
        },
        options: {
            plugins: { 
                legend: { display: true, position: 'bottom' }
            }
        }
    });

    // Gráfico de Proveedores
    const ctxProv = document.getElementById('graficoProveedor').getContext('2d');
    new Chart(ctxProv, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(
                $proveedores->whereIn('id', $conteoProveedor->keys())->pluck('nombre', 'id')->values()
            ) !!},
            datasets: [{
                data: {!! json_encode($conteoProveedor->values()) !!},
                backgroundColor: [
                    '#ff7043', '#7e57c2', '#26a69a', '#ec407a', '#8d6e63', '#b2dfdb'
                ]
            }]
        },
        options: {
            plugins: { 
                legend: { display: true, position: 'bottom' }
            }
        }
    });
</script>
@endpush
@endsection
