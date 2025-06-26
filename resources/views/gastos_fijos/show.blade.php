@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Detalle de Gasto Fijo</h2>
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ $gasto->nombre_gasto }}</span>
            <a href="{{ route('gastos_fijos.edit', $gasto) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Editar
            </a>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Proveedor</dt>
                <dd class="col-sm-9">{{ $gasto->proveedor->nombre ?? '-' }}</dd>
                <dt class="col-sm-3">Monto Mensual</dt>
                <dd class="col-sm-9">${{ number_format($gasto->monto,2) }}</dd>
                <dt class="col-sm-3">Fecha Vencimiento</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($gasto->fecha_vencimiento)->format('d/m/Y') }}</dd>
                <dt class="col-sm-3">Categoría</dt>
                <dd class="col-sm-9">{{ $gasto->categoria ?? '-' }}</dd>
                <dt class="col-sm-3">Estatus</dt>
                <dd class="col-sm-9">
                    @if($gasto->pagado)
                        <span class="badge bg-success">Pagado</span>
                    @else
                        <span class="badge bg-danger">Pendiente</span>
                    @endif
                </dd>
            </dl>
        </div>
        <div class="card-footer text-end">
            <form method="POST" action="{{ route('gastos_fijos.destroy', $gasto) }}" style="display:inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar gasto?')">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('gastos_fijos.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>
</div>
@endsection
