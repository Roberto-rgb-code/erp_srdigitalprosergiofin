@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Proyectos de Desarrollo de Software</h2>
    <div class="mb-3 d-flex flex-wrap gap-2">
        <a href="{{ route('desarrollo_software.create') }}" class="btn btn-primary">Nuevo proyecto</a>
        <a href="{{ route('desarrollo_software.export.excel') }}" class="btn btn-outline-success">Exportar Excel</a>
        <a href="{{ route('desarrollo_software.export.pdf') }}" class="btn btn-outline-danger">Exportar PDF</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- DASHBOARD CARDS --}}
    <div class="row mb-4 g-3">
        <div class="col-md-2">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Total</h6>
                    <h3>{{ $totalProyectos }}</h3>
                    <small class="text-primary">Proyectos</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Finalizados</h6>
                    <h3>{{ $proyectosFinalizados }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-info">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">En desarrollo</h6>
                    <h3>{{ $proyectosEnDesarrollo }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-warning">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Testing</h6>
                    <h3>{{ $proyectosTesting }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-secondary">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Planeados</h6>
                    <h3>{{ $proyectosPlaneados }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2 d-flex align-items-center justify-content-center">
            <canvas id="graficoEstados" height="70"></canvas>
        </div>
    </div>

    {{-- TABLA DE PROYECTOS --}}
    <div class="table-responsive shadow rounded">
        <table class="table table-bordered align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Responsable</th>
                    <th>Estado</th>
                    <th>Inicio</th>
                    <th>Entrega</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proyectos as $p)
                    <tr>
                        <td><a href="{{ route('desarrollo_software.show', $p) }}">{{ $p->nombre }}</a></td>
                        <td>{{ $p->cliente->nombre ?? '-' }}</td>
                        <td>{{ $p->tipoSoftware->nombre ?? '-' }}</td>
                        <td>{{ $p->responsable->nombre ?? '-' }}</td>
                        <td>
                            @php
                                $badge = [
                                    'Finalizado' => 'success',
                                    'En desarrollo' => 'info',
                                    'Testing' => 'warning',
                                    'Planeado' => 'secondary'
                                ][$p->estado] ?? 'dark';
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ $p->estado }}</span>
                        </td>
                        <td>{{ $p->fecha_inicio }}</td>
                        <td>{{ $p->fecha_fin }}</td>
                        <td>
                            <a href="{{ route('desarrollo_software.edit', $p) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('desarrollo_software.destroy', $p) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $proyectos->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(!empty($graficoEstados))
    const ctx = document.getElementById('graficoEstados').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($graficoEstados)) !!},
            datasets: [{
                data: {!! json_encode(array_values($graficoEstados)) !!},
                backgroundColor: [
                    '#0d6efd', '#198754', '#ffc107', '#6c757d', '#dc3545'
                ]
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
@endif
</script>
@endpush
