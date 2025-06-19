@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Contable</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Saldo en Bancos</h5>
                <p>${{ number_format($saldo_bancos, 2) }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Saldo en Caja Chica</h5>
                <p>${{ number_format($saldo_caja, 2) }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Cuentas por Cobrar</h5>
                <p>${{ number_format($cxc, 2) }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Cuentas por Pagar</h5>
                <p>${{ number_format($cxp, 2) }}</p>
            </div>
        </div>
    </div>

    <h3>Últimos Movimientos</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Póliza</th>
                <th>Cuenta Contable</th>
                <th>Concepto</th>
                <th>Debe</th>
                <th>Haber</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ultimos_movimientos as $mov)
            <tr>
                <td>{{ $mov->fecha->format('d-m-Y') }}</td>
                <td>{{ $mov->poliza->folio ?? '-' }}</td>
                <td>{{ $mov->cuentaContable->nombre ?? '-' }}</td>
                <td>{{ $mov->concepto }}</td>
                <td>${{ number_format($mov->debe, 2) }}</td>
                <td>${{ number_format($mov->haber, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No hay movimientos recientes</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Catálogo de Cuentas Contables</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Cuenta Padre</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuentas as $cuenta)
            <tr>
                <td>{{ $cuenta->codigo }}</td>
                <td>{{ $cuenta->nombre }}</td>
                <td>{{ $cuenta->tipo }}</td>
                <td>{{ $cuenta->cuentaPadre->nombre ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No hay cuentas registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        <h4>Submódulos</h4>
        <ul>
            <li><a href="{{ route('cuentas_contables.index') }}">Catálogo de Cuentas</a></li>
            <li><a href="{{ route('polizas_contables.index') }}">Pólizas Contables</a></li>
            <li><a href="{{ route('diario_contable.index') }}">Diario Contable</a></li>
        </ul>
    </div>
</div>
@endsection
