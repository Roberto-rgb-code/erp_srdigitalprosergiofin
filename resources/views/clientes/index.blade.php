@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="fw-bold mb-0"><i class="bi bi-person-lines-fill me-2"></i> Clientes</h2>
        <div>
            <a href="{{ route('clientes.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Cliente
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Métricas rápidas --}}
    <div class="row mb-4 g-3">
        <div class="col-6 col-md-3">
            <div class="card text-bg-primary-subtle border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="fs-3"><i class="bi bi-people-fill"></i></div>
                    <div class="fw-bold fs-5">{{ $clientes->total() }}</div>
                    <small class="text-uppercase text-secondary">Clientes registrados</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-bg-info-subtle border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="fs-3"><i class="bi bi-building"></i></div>
                    <div class="fw-bold fs-5">
                        {{ $clientes->where('empresa', '!=', '')->unique('empresa')->count() }}
                    </div>
                    <small class="text-uppercase text-secondary">Empresas distintas</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-bg-success-subtle border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="fs-3"><i class="bi bi-123"></i></div>
                    <div class="fw-bold fs-5">
                        {{ $clientes->where('datoFiscal.rfc', '!=', null)->count() }}
                    </div>
                    <small class="text-uppercase text-secondary">Clientes con RFC</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-bg-warning-subtle border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="fs-3"><i class="bi bi-phone"></i></div>
                    <div class="fw-bold fs-5">
                        {{ $clientes->where('contacto', '!=', '')->unique('contacto')->count() }}
                    </div>
                    <small class="text-uppercase text-secondary">Contactos únicos</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold text-secondary mb-2">Clientes por tipo</h6>
                    <canvas id="graficoTipo" height="170"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold text-secondary mb-2">Clientes con RFC</h6>
                    <canvas id="graficoRfc" height="170"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="rfc" class="form-control" placeholder="RFC" value="{{ request('rfc') }}">
        </div>
        <div class="col-auto d-flex align-items-end gap-2">
            <button class="btn btn-outline-secondary">Buscar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-light border">Limpiar</a>
        </div>
        <div class="col-auto d-flex align-items-end gap-2">
            <a href="{{ route('clientes.export.excel', request()->all()) }}" class="btn btn-success shadow-sm">
                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
            </a>
            <a href="{{ route('clientes.export.pdf', request()->all()) }}" class="btn btn-danger shadow-sm">
                <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
            </a>
        </div>
    </form>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Folio</th>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>RFC</th>
                    <th>Contacto</th>
                    <th>Tipo</th>
                    <th>Dirección</th>
                    <th>Correo Fiscal</th>
                    <th style="width:150px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>
                            <a href="{{ route('clientes.show', $c) }}" class="fw-semibold text-primary">
                                {{ $c->nombre_completo }}
                            </a>
                        </td>
                        <td>{{ $c->empresa }}</td>
                        <td>{{ $c->datoFiscal->rfc ?? '-' }}</td>
                        <td>{{ $c->contacto }}</td>
                        <td>{{ $c->tipo_cliente }}</td>
                        <td>{{ $c->direccion }}</td>
                        <td>{{ $c->datoFiscal->correo ?? '-' }}</td>
                        <td>
                            <a href="{{ route('clientes.edit', $c) }}" class="btn btn-warning btn-sm me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('clientes.destroy', $c) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @if($c->datoFiscal)
                            <a href="{{ route('datos-fiscales.show', $c->datoFiscal) }}" class="btn btn-info btn-sm" title="Datos Fiscales">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-secondary">No hay clientes registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $clientes->links() }}
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Clientes por Tipo
    const ctxTipo = document.getElementById('graficoTipo').getContext('2d');
    new Chart(ctxTipo, {
        type: 'pie',
        data: {
            labels: {!! json_encode($conteoTipo->keys()) !!},
            datasets: [{
                data: {!! json_encode($conteoTipo->values()) !!},
                backgroundColor: [
                    '#0d6efd', '#20c997', '#ffc107', '#6610f2', '#f06595', '#fd7e14'
                ]
            }]
        },
        options: {
            plugins: { legend: { display: true, position: 'bottom' } }
        }
    });

    // Clientes con RFC vs sin RFC
    const ctxRfc = document.getElementById('graficoRfc').getContext('2d');
    new Chart(ctxRfc, {
        type: 'pie',
        data: {
            labels: ['Con RFC', 'Sin RFC'],
            datasets: [{
                data: [
                    {{ $clientes->where('datoFiscal.rfc','!=', null)->count() }},
                    {{ $clientes->where('datoFiscal.rfc', null)->count() }}
                ],
                backgroundColor: [
                    '#198754', '#adb5bd'
                ]
            }]
        },
        options: {
            plugins: { legend: { display: true, position: 'bottom' } }
        }
    });
</script>
@endsection
