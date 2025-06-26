@extends('layouts.app')
@section('content')
<div class="card mt-4">
    <div class="card-header">
        Detalle de Movimiento de Caja
        <a href="{{ route('punto_venta.index') }}" class="btn btn-sm btn-secondary float-end">Volver</a>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-4">Fecha</dt>
            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($punto_ventum->fecha)->format('d/m/Y') }}</dd>
            <dt class="col-sm-4">Tipo</dt>
            <dd class="col-sm-8">
                @if($punto_ventum->tipo == 'entrada')
                    <span class="badge bg-success">Entrada</span>
                @else
                    <span class="badge bg-danger">Salida</span>
                @endif
            </dd>
            <dt class="col-sm-4">Monto</dt>
            <dd class="col-sm-8">${{ number_format($punto_ventum->monto,2) }}</dd>
            <dt class="col-sm-4">Descripción</dt>
            <dd class="col-sm-8">{{ $punto_ventum->descripcion ?? '-' }}</dd>
            <dt class="col-sm-4">Comprobante</dt>
            <dd class="col-sm-8">
                @if($punto_ventum->comprobante)
                    <a href="{{ asset('storage/'.$punto_ventum->comprobante) }}" target="_blank">Ver archivo</a>
                @else
                    <span class="text-muted">-</span>
                @endif
            </dd>
        </dl>
        <a href="{{ route('punto_venta.edit', ['punto_ventum' => $punto_ventum->id]) }}" class="btn btn-warning">Editar</a>
        <form method="POST" action="{{ route('punto_venta.destroy', ['punto_ventum' => $punto_ventum->id]) }}" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('¿Eliminar este movimiento?')">
                <i class="bi bi-trash"></i> Eliminar
            </button>
        </form>
    </div>
</div>
@endsection
