@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Servicios Empresariales</h2>
        <div>
            <a href="{{ route('servicios_empresariales.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Servicio Empresarial
            </a>
            <a href="{{ route('servicios_empresariales.export.excel') }}" class="btn btn-success ms-2">
                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
            </a>
            <a href="{{ route('servicios_empresariales.export.pdf') }}" class="btn btn-danger ms-2">
                <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
            </a>
        </div>
    </div>

    {{-- Resumen de servicios --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow rounded-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Servicios</h5>
                    <h2 class="fw-bold text-primary">{{ $servicios->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow rounded-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Activos</h5>
                    <h2 class="fw-bold text-success">
                        {{ $servicios->where('estatus','Activa')->count() }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow rounded-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Inactivos</h5>
                    <h2 class="fw-bold text-danger">
                        {{ $servicios->where('estatus','Inactiva')->count() }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-2">
            <div class="card shadow rounded-4">
                <div class="card-body">
                    <h6 class="card-title">Estatus de Servicios</h6>
                    <canvas id="chartEstatus"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card shadow rounded-4">
                <div class="card-body">
                    <h6 class="card-title">Servicios por Cliente</h6>
                    <canvas id="chartClientes"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3">
            <select name="cliente_id" class="form-select" onchange="this.form.submit()">
                <option value="">Todos los clientes</option>
                @foreach($clientes as $cli)
                    <option value="{{ $cli->id }}" {{ request('cliente_id') == $cli->id ? 'selected' : '' }}>
                        {{ $cli->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="estatus" class="form-select" onchange="this.form.submit()">
                <option value="">Todos los estatus</option>
                <option value="Activa" {{ request('estatus') == 'Activa' ? 'selected' : '' }}>Activa</option>
                <option value="Inactiva" {{ request('estatus') == 'Inactiva' ? 'selected' : '' }}>Inactiva</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100" type="submit"><i class="bi bi-search"></i> Buscar</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-outline-dark w-100"><i class="bi bi-x-circle"></i> Limpiar</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabla --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Póliza</th>
                    <th>Estatus</th>
                    <th>Comentarios</th>
                    <th>Acciones</th>
                    <th>Submódulos</th>
                </tr>
            </thead>
            <tbody>
                @forelse($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->id }}</td>
                        <td>{{ $servicio->cliente->nombre ?? '-' }}</td>
                        <td>{{ $servicio->poliza ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $servicio->estatus == 'Activa' ? 'bg-success' : 'bg-danger' }}">
                                {{ $servicio->estatus }}
                            </span>
                        </td>
                        <td>{{ $servicio->comentarios }}</td>
                        <td>
                            <a href="{{ route('servicios_empresariales.edit', $servicio) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('servicios_empresariales.destroy', $servicio) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group flex-wrap">
                                <a href="{{ route('servicios_empresariales.inventarios.index', $servicio->id) }}" class="btn btn-sm btn-secondary mb-1">Inventario</a>
                                <a href="{{ route('servicios_empresariales.usuarios_clientes.index', $servicio->id) }}" class="btn btn-sm btn-info mb-1">Usuarios</a>
                                <a href="{{ route('servicios_empresariales.configuraciones_clientes.index', $servicio->id) }}" class="btn btn-sm btn-warning mb-1">Configuraciones</a>
                                <a href="{{ route('servicios_empresariales.tickets_soporte.index', $servicio->id) }}" class="btn btn-sm btn-success mb-1">Tickets</a>
                                <a href="{{ route('servicios_empresariales.seguimientos_ticket.index', $servicio->id) }}" class="btn btn-sm btn-primary mb-1">Seguimiento</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay servicios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $servicios->links() }}
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Datos para estatus
    var dataEstatus = {
        labels: ['Activa', 'Inactiva'],
        datasets: [{
            data: [
                {{ $servicios->where('estatus','Activa')->count() }},
                {{ $servicios->where('estatus','Inactiva')->count() }}
            ],
            backgroundColor: ['#28a745','#dc3545'],
        }]
    };
    var ctxEstatus = document.getElementById('chartEstatus').getContext('2d');
    new Chart(ctxEstatus, {
        type: 'doughnut',
        data: dataEstatus,
        options: {
            plugins: { legend: { position: 'bottom' }},
            cutout: "65%",
        }
    });

    // Servicios por cliente
    var dataClientes = {
        labels: {!! json_encode($clientes->pluck('nombre')) !!},
        datasets: [{
            label: 'Servicios',
            data: [
                @foreach($clientes as $cli)
                    {{ $servicios->where('cliente_id', $cli->id)->count() }},
                @endforeach
            ],
            backgroundColor: Array.from({length: {{ $clientes->count() }}}, (_,i) =>
                `rgba(54, 162, 235, ${0.5 + (i*0.2)/({{ $clientes->count() }})})`
            ),
        }]
    };
    var ctxClientes = document.getElementById('chartClientes').getContext('2d');
    new Chart(ctxClientes, {
        type: 'bar',
        data: dataClientes,
        options: {
            plugins: { legend: { display: false }},
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endsection
