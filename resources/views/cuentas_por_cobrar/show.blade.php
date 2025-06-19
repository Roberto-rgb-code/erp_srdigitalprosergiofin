@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Detalle Cuenta por Cobrar</h2>
    <div class="card p-4 mb-4">
        <div><strong>Folio:</strong> {{ $cuenta->folio }}</div>
        <div><strong>Cliente:</strong> {{ $cuenta->cliente->nombre ?? '' }}</div>
        <div><strong>Emisión:</strong> {{ $cuenta->fecha_emision }}</div>
        <div><strong>Vencimiento:</strong> {{ $cuenta->fecha_vencimiento }}</div>
        <div><strong>Monto total:</strong> ${{ number_format($cuenta->monto_total,2) }}</div>
        <div><strong>Saldo pendiente:</strong> ${{ number_format($cuenta->saldo_pendiente,2) }}</div>
        <div><strong>Estatus:</strong> <span class="badge" style="background:
                        @if($cuenta->status=='Atrasado') #ff6b6b
                        @elseif($cuenta->status=='En tiempo') #51cf66
                        @else #adb5bd
                        @endif
                    ">{{ $cuenta->status }}</span></div>
        @if($cuenta->documento)
            <div><a href="{{ Storage::url($cuenta->documento) }}" target="_blank">Documento</a></div>
        @endif
        <div><strong>Descripción:</strong> {{ $cuenta->descripcion }}</div>
    </div>

    <h4>Registrar Cobro</h4>
    <form action="{{ route('cuentas_por_cobrar.cobros', $cuenta->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Fecha de cobro</label>
                <input type="date" name="fecha_cobro" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Monto cobrado</label>
                <input type="number" name="monto_cobrado" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Recibo (opcional)</label>
                <input type="file" name="recibo" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label>Observaciones</label>
                <input type="text" name="observaciones" class="form-control">
            </div>
        </div>
        <button class="btn btn-success">Registrar cobro</button>
    </form>

    <h4>Historial de cobros</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th><th>Monto</th><th>Recibo</th><th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuenta->cobros as $cobro)
                <tr>
                    <td>{{ $cobro->fecha_cobro }}</td>
                    <td>${{ number_format($cobro->monto_cobrado,2) }}</td>
                    <td>
                        @if($cobro->recibo)
                            <a href="{{ Storage::url($cobro->recibo) }}" target="_blank">Ver recibo</a>
                        @endif
                    </td>
                    <td>{{ $cobro->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
