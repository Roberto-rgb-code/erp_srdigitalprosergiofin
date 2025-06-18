@extends('layouts.app')
@section('content')
<div class="d-flex justify-between items-center mb-4 gap-2 flex-wrap">
    <h2 class="mb-0">Órdenes de Servicio</h2>
    <div>
        <a href="{{ route('taller.create') }}" class="btn btn-primary me-1">Nueva Orden</a>
        <a href="{{ route('taller.export.excel') }}" class="btn btn-outline-success me-1">Exportar Excel</a>
        <a href="{{ route('taller.export.pdf') }}" class="btn btn-outline-danger me-1">Exportar PDF</a>
        <a href="{{ route('equipos.index') }}" class="btn btn-info">Ir a Catálogo de Equipos</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Gráfico de órdenes por estado --}}
<div class="mb-4">
    <canvas id="graficoEstados"></canvas>
</div>

<h5 class="mt-4">Órdenes de Servicio Registradas</h5>
<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>Folio</th>
            <th>Cliente</th>
            <th>Tipo cliente</th>
            <th>Equipo</th>
            <th>IMEI/Serie</th>
            <th>Técnico</th>
            <th>Ingreso</th>
            <th>Entrega</th>
            <th>Estatus</th>
            <th>Costo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($talleres as $t)
            <tr>
                <td>{{ $t->folio }}</td>
                <td>{{ $t->cliente->nombre ?? '-' }}</td>
                <td>{{ $t->tipo_cliente }}</td>
                <td>
                    {{ $t->equipo->tipo ?? '-' }}
                    {{ $t->equipo->marca ?? '' }}
                    {{ $t->equipo->modelo ?? '' }}
                </td>
                <td>{{ $t->equipo->imei ?? '' }}</td>
                <td>{{ $t->tecnico->nombre ?? '-' }}</td>
                <td>{{ $t->fecha_ingreso }}</td>
                <td>{{ $t->fecha_entrega }}</td>
                <td>{{ $t->status }}</td>
                <td>${{ number_format($t->costo_total,2) }}</td>
                <td>
                    <a href="{{ route('taller.show', $t) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('taller.edit', $t) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('taller.destroy', $t) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="11">No hay órdenes registradas.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $talleres->links() }}

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(isset($graficoEstados))
    const ctx = document.getElementById('graficoEstados').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($graficoEstados)) !!},
            datasets: [{
                data: {!! json_encode(array_values($graficoEstados)) !!},
                backgroundColor: [
                    '#6ec1e4', '#f7b731', '#e17055', '#00b894', '#a29bfe'
                ],
            }]
        }
    });
@endif
</script>
@endpush
@endsection
