@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cuentas por Cobrar</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <a href="{{ route('cuentas_por_cobrar.create') }}" class="btn btn-primary mb-2">
                <i class="bi bi-plus-circle"></i> Nueva Cuenta
            </a>
            <a href="{{ route('cuentas_por_cobrar.export.excel') }}" class="btn btn-success mb-2">
                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
            </a>
            <a href="{{ route('cuentas_por_cobrar.export.pdf') }}" class="btn btn-danger mb-2">
                <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
            </a>
        </div>
        <span class="fs-5">
            <strong>Total Deuda: </strong>$ {{ number_format($totalDeuda, 2) }}
        </span>
    </div>

    <div class="card mb-4 shadow">
        <div class="card-body">
            <h5 class="card-title mb-3">Gráfico: Deuda pendiente por Cliente</h5>
            <canvas id="graficoCuentasPorCobrar" height="80"></canvas>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Venta</th>
                    <th>Folio Factura</th>
                    <th>Fecha Emisión</th>
                    <th>Fecha Vencimiento</th>
                    <th>Monto Total</th>
                    <th>Saldo Pendiente</th>
                    <th>Documento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cuentas as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->cliente->nombre ?? '-' }}</td>
                        <td>{{ $c->venta?->id ?? '-' }}</td>
                        <td>{{ $c->folio_factura }}</td>
                        <td>{{ $c->fecha_emision ? \Carbon\Carbon::parse($c->fecha_emision)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $c->fecha_vencimiento ? \Carbon\Carbon::parse($c->fecha_vencimiento)->format('d/m/Y') : '-' }}</td>
                        <td>${{ number_format($c->monto_total, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $c->saldo_pendiente == 0 ? 'success' : ($c->saldo_pendiente > 0 && \Carbon\Carbon::parse($c->fecha_vencimiento)->isPast() ? 'danger' : 'warning') }}">
                                ${{ number_format($c->saldo_pendiente, 2) }}
                            </span>
                        </td>
                        <td>
                            @if($c->documento)
                                <a href="{{ asset('storage/' . $c->documento) }}" target="_blank" class="btn btn-link btn-sm">Ver</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cuentas_por_cobrar.show', $c) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('cuentas_por_cobrar.edit', $c) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('cuentas_por_cobrar.destroy', $c) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No hay cuentas por cobrar registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $cuentas->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Puedes obtener estos datos con un endpoint API o pasarlos directo desde PHP ---
    // Aquí los paso directo para hacerlo plug&play:
    const datosClientes = @json(
        \App\Models\CuentaPorCobrar::with('cliente')
            ->selectRaw('cliente_id, SUM(saldo_pendiente) as total')
            ->groupBy('cliente_id')
            ->get()
            ->map(fn($c) => [
                'cliente' => $c->cliente->nombre ?? 'Sin nombre',
                'total'   => (float)$c->total
            ])
    );

    const labels = datosClientes.map(x => x.cliente);
    const values = datosClientes.map(x => x.total);

    new Chart(document.getElementById('graficoCuentasPorCobrar'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Saldo pendiente',
                data: values,
                borderWidth: 1,
                backgroundColor: '#0d6efd60',
                borderColor: '#0d6efd'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endsection
