@extends('layouts.app')
@section('content')
    <h2>Proyectos de Cableado Estructurado</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filtros --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-2">
            <input type="text" name="nombre_proyecto" class="form-control" placeholder="Nombre Proyecto" value="{{ request('nombre_proyecto') }}">
        </div>
        <div class="col-md-2">
            <select name="cliente_id" class="form-select">
                <option value="">Cliente</option>
                @foreach($clientes as $cl)
                    <option value="{{ $cl->id }}" @selected(request('cliente_id') == $cl->id)>{{ $cl->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="tipo_instalacion" class="form-control" placeholder="Tipo instalación" value="{{ request('tipo_instalacion') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="responsable_id" class="form-control" placeholder="Responsable" value="{{ request('responsable_id') }}">
        </div>
        <div class="col-md-2">
            <select name="estatus" class="form-select">
                <option value="">Estado</option>
                <option value="Planeado" @selected(request('estatus') == 'Planeado')>Planeado</option>
                <option value="En curso" @selected(request('estatus') == 'En curso')>En curso</option>
                <option value="Finalizado" @selected(request('estatus') == 'Finalizado')>Finalizado</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary">Filtrar</button>
            <a href="{{ route('cableado.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('cableado.create') }}" class="btn btn-primary">Nuevo Proyecto</a>
        <div>
            <a href="{{ route('cableado.export.excel') }}" class="btn btn-success btn-sm">Exportar Excel</a>
            <a href="{{ route('cableado.export.pdf') }}" class="btn btn-danger btn-sm">Exportar PDF</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Estado de los proyectos</h6>
                    <canvas id="graficoEstado" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Proyectos por Cliente</h6>
                    <canvas id="graficoCliente" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Dirección</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($cableados as $p)
            <tr>
                <td>{{ $p->nombre_proyecto }}</td>
                <td>{{ $p->cliente->nombre ?? '-' }}</td>
                <td>{{ $p->tipo_instalacion }}</td>
                <td>{{ Str::limit($p->direccion, 25) }}</td>
                <td>{{ $p->fecha_inicio }}</td>
                <td>{{ $p->fecha_fin }}</td>
                <td>{{ $p->responsable_id }}</td>
                <td>
                    <span class="badge
                        @if($p->estatus == 'Planeado') bg-secondary
                        @elseif($p->estatus == 'En curso') bg-warning
                        @elseif($p->estatus == 'Finalizado') bg-success
                        @else bg-light text-dark @endif">
                        {{ $p->estatus }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('cableado.show', $p) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('cableado.edit', $p) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('cableado.destroy', $p) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Borrar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="9">No hay proyectos registrados.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div>
        {{ $cableados->links() }}
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // === Gráfico de ESTADO ===
    @php
        $dataEstado = $cableados->groupBy('estatus')->map->count();
    @endphp
    const ctxEstado = document.getElementById('graficoEstado').getContext('2d');
    new Chart(ctxEstado, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($dataEstado->keys()) !!},
            datasets: [{
                data: {!! json_encode($dataEstado->values()) !!},
                backgroundColor: ['#e9c46a','#f4a261','#2a9d8f'],
                borderRadius: 8
            }]
        },
        options: {
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });

    // === Gráfico de CLIENTE ===
    @php
        $dataCliente = $cableados->groupBy('cliente_id')
            ->map(fn($items) => $items->count());
        $clientesNombres = $cableados->mapWithKeys(function($item){
            return [$item->cliente_id => $item->cliente->nombre ?? 'Sin cliente'];
        });
    @endphp
    const ctxCliente = document.getElementById('graficoCliente').getContext('2d');
    new Chart(ctxCliente, {
        type: 'bar',
        data: {
            labels: {!! json_encode($clientesNombres->unique()->values()) !!},
            datasets: [{
                label: 'Cantidad de proyectos',
                data: {!! json_encode($dataCliente->values()) !!},
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
