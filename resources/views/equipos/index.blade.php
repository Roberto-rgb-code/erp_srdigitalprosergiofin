@extends('layouts.app')
@section('content')
<div class="d-flex justify-between items-center mb-3">
    <h2>Catálogo de Equipos</h2>
    <a href="{{ route('equipos.create') }}" class="btn btn-primary">Registrar nuevo equipo</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Gráfico de equipos por tipo --}}
<div class="mb-4">
    <canvas id="graficoTipos"></canvas>
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>IMEI/Serie</th>
            <th>Condición</th>
            <th>Estética</th>
            <th>Zona</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($equipos as $e)
            <tr>
                <td>{{ $e->id }}</td>
                <td>{{ $e->tipo }}</td>
                <td>{{ $e->marca }}</td>
                <td>{{ $e->modelo }}</td>
                <td>
                    <span style="display:inline-block;width:20px;height:20px;border-radius:50%;background:{{ $e->color }};border:1px solid #ccc;"></span>
                    {{ $e->color }}
                </td>
                <td>{{ $e->imei }}</td>
                <td>{{ $e->condicion_fisica }}</td>
                <td>{{ $e->estetica }}</td>
                <td>{{ $e->zona_trabajo }}</td>
                <td>
                    <a href="{{ route('equipos.show', $e) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('equipos.edit', $e) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('equipos.destroy', $e) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="10">Sin equipos registrados.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $equipos->links() }}

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(isset($graficoTipos))
    const ctx = document.getElementById('graficoTipos').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($graficoTipos)) !!},
            datasets: [{
                label: 'Cantidad',
                data: {!! json_encode(array_values($graficoTipos)) !!},
                borderRadius: 6
            }]
        },
    });
@endif
</script>
@endpush
@endsection
