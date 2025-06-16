@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Contabilidad &mdash; Dashboard General</h2>

    <div class="row mb-4">
        {{-- Indicadores clave --}}
        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-header">Saldo Bancos</div>
                <div class="card-body">
                    <h4 class="card-title">${{ number_format($saldo_bancos ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info mb-3">
                <div class="card-header">Caja Chica</div>
                <div class="card-body">
                    <h4 class="card-title">${{ number_format($saldo_caja ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-header">CxC Pendiente</div>
                <div class="card-body">
                    <h4 class="card-title">${{ number_format($cxc ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-danger mb-3">
                <div class="card-header">CxP Pendiente</div>
                <div class="card-body">
                    <h4 class="card-title">${{ number_format($cxp ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos rápidos --}}
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Balance mensual</div>
                <div class="card-body">
                    {{-- Aquí iría un Chart.js, ejemplo: --}}
                    <canvas id="balanceMensual"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Estado de Resultados</div>
                <div class="card-body">
                    <canvas id="estadoResultados"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos a submódulos --}}
    <div class="row mb-4">
        <div class="col">
            <a href="{{ route('diario_contable.index') }}" class="btn btn-outline-primary btn-lg m-1">Libro Diario</a>
            <a href="{{ route('polizas_contables.index') }}" class="btn btn-outline-secondary btn-lg m-1">Pólizas Contables</a>
            <a href="{{ route('cuentas_contables.index') }}" class="btn btn-outline-success btn-lg m-1">Catálogo de Cuentas</a>
            <a href="#" class="btn btn-outline-info btn-lg m-1">Reportes SAT</a>
            {{-- Agrega más enlaces según tus módulos --}}
        </div>
    </div>

    {{-- Últimos movimientos contables --}}
    <div class="card mb-4">
        <div class="card-header">Últimos Movimientos</div>
        <div class="card-body p-0">
            <table class="table mb-0 table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Póliza</th>
                        <th>Cuenta</th>
                        <th>Debe</th>
                        <th>Haber</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimos_movimientos as $m)
                        <tr>
                            <td>{{ $m->fecha }}</td>
                            <td>{{ $m->poliza->id ?? '-' }}</td>
                            <td>{{ $m->cuenta->codigo ?? '' }} - {{ $m->cuenta->nombre ?? '' }}</td>
                            <td class="text-end">${{ number_format($m->debe, 2) }}</td>
                            <td class="text-end">${{ number_format($m->haber, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Sin movimientos recientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Ejemplo Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('balanceMensual').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {!! json_encode($grafica_balance) !!},
        options: {responsive: true}
    });

    var ctx2 = document.getElementById('estadoResultados').getContext('2d');
    var chart2 = new Chart(ctx2, {
        type: 'line',
        data: {!! json_encode($grafica_resultados) !!},
        options: {responsive: true}
    });
</script>
@endsection
