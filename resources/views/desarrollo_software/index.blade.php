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
    <div class="table-responsive shadow rounded mb-5">
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
                        <td>{{ $p->cliente->nombre_completo ?? '-' }}</td>
                        <td>{{ $p->tipo_software ?? '-' }}</td>
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

    {{-- KANBAN --}}
    <h3>Seguimiento Kanban</h3>
    <div class="kanban-board d-flex gap-3 flex-wrap">
        @php
            $estados = ['Planeado', 'En desarrollo', 'Testing', 'Finalizado'];
        @endphp
        @foreach ($estados as $estado)
            <div class="kanban-column p-2 border rounded" style="flex: 1; min-width: 250px; max-height: 600px; overflow-y: auto;">
                <h5 class="text-center">{{ $estado }}</h5>
                <div class="kanban-list" data-estado="{{ $estado }}">
                    @foreach($proyectos->where('estado', $estado) as $proyecto)
                        <div class="kanban-card p-2 mb-2 border rounded bg-light" data-id="{{ $proyecto->id }}" style="cursor: grab;">
                            <strong>{{ $proyecto->nombre }}</strong><br>
                            <small>{{ $proyecto->cliente->nombre_completo ?? '-' }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
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

// Kanban Drag & Drop con SortableJS
document.querySelectorAll('.kanban-list').forEach(list => {
    new Sortable(list, {
        group: 'kanban',
        animation: 150,
        onEnd: function (evt) {
            const proyectoId = evt.item.dataset.id;
            const nuevoEstado = evt.to.dataset.estado;

            fetch(`/desarrollo_software/${proyectoId}/estado`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ estado: nuevoEstado }),
            })
            .then(res => res.json())
            .then(data => {
                if(!data.success) {
                    alert('Error al actualizar estado');
                    location.reload();
                }
            })
            .catch(() => {
                alert('Error en la conexión');
                location.reload();
            });
        }
    });
});
</script>
@endpush
