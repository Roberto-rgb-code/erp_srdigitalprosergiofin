@extends('layouts.app')

@section('content')
    <h2>Dashboard de Finanzas</h2>
    <div class="row mb-4">
        <div class="col">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Ingresos</h5>
                    <p class="card-text">${{ number_format($total_ingresos, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Egresos</h5>
                    <p class="card-text">${{ number_format($total_egresos, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Por Cobrar</h5>
                    <p class="card-text">${{ number_format($total_por_cobrar, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Por Pagar</h5>
                    <p class="card-text">${{ number_format($total_por_pagar, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Saldo Bancos</h5>
                    <p class="card-text">${{ number_format($saldo_bancos, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Caja Chica</h5>
                    <p class="card-text">${{ number_format($saldo_caja, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tablas rápidas --}}
    <div class="row">
        <div class="col-md-6">
            <h4>Últimos Ingresos</h4>
            <table class="table table-sm">
                <thead><tr><th>Fecha</th><th>Monto</th><th>Tipo</th><th>Descripción</th></tr></thead>
                <tbody>
                    @foreach($ingresos as $i)
                        <tr>
                            <td>{{ $i->fecha }}</td>
                            <td>${{ number_format($i->monto, 2) }}</td>
                            <td>{{ $i->tipo_ingreso }}</td>
                            <td>{{ $i->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('ingresos.index') }}" class="btn btn-outline-success btn-sm">Ver todos</a>
        </div>
        <div class="col-md-6">
            <h4>Últimos Egresos</h4>
            <table class="table table-sm">
                <thead><tr><th>Fecha</th><th>Monto</th><th>Tipo</th><th>Descripción</th></tr></thead>
                <tbody>
                    @foreach($egresos as $e)
                        <tr>
                            <td>{{ $e->fecha }}</td>
                            <td>${{ number_format($e->monto, 2) }}</td>
                            <td>{{ $e->tipo_egreso }}</td>
                            <td>{{ $e->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('egresos.index') }}" class="btn btn-outline-danger btn-sm">Ver todos</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Cuentas por Cobrar</h4>
            <table class="table table-sm">
                <thead><tr><th>Cliente</th><th>Saldo</th><th>Vence</th></tr></thead>
                <tbody>
                    @foreach($cobros as $c)
                        <tr>
                            <td>{{ $c->cliente->nombre ?? '-' }}</td>
                            <td>${{ number_format($c->saldo, 2) }}</td>
                            <td>{{ $c->fecha_vencimiento }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('cuentas_por_cobrar.index') }}" class="btn btn-outline-info btn-sm">Ver todas</a>
        </div>
        <div class="col-md-6">
            <h4>Cuentas por Pagar</h4>
            <table class="table table-sm">
                <thead><tr><th>Proveedor</th><th>Saldo</th><th>Vence</th></tr></thead>
                <tbody>
                    @foreach($pagos as $p)
                        <tr>
                            <td>{{ $p->proveedor->nombre ?? '-' }}</td>
                            <td>${{ number_format($p->saldo, 2) }}</td>
                            <td>{{ $p->fecha_vencimiento }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('cuentas_por_pagar.index') }}" class="btn btn-outline-warning btn-sm">Ver todas</a>
        </div>
    </div>

    {{-- Aquí va el gráfico de balance financiero, por ejemplo Chart.js, con $ingresos_por_mes y $egresos_por_mes --}}
    <div class="mt-5">
        <h4>Balance financiero mensual</h4>
        <canvas id="balanceChart"></canvas>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('balanceChart').getContext('2d');
const ingresos = @json(array_values($ingresos_por_mes));
const egresos = @json(array_values($egresos_por_mes));
const labels = @json(array_keys($ingresos_por_mes));
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            { label: 'Ingresos', data: ingresos, backgroundColor: 'rgba(40,167,69,0.5)' },
            { label: 'Egresos', data: egresos, backgroundColor: 'rgba(220,53,69,0.5)' }
        ]
    },
    options: { responsive: true }
});
</script>
@endpush
