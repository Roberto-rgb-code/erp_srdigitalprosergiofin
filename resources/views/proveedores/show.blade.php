@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Detalle de Proveedor</h2>
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ $proveedor->nombre }}</span>
            <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Editar
            </a>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Ejecutivo de venta</dt>
                <dd class="col-sm-9">{{ $proveedor->ejecutivo_venta ?? '-' }}</dd>
                <dt class="col-sm-3">Teléfono</dt>
                <dd class="col-sm-9">{{ $proveedor->telefono ?? '-' }}</dd>
                <dt class="col-sm-3">Dirección</dt>
                <dd class="col-sm-9">{{ $proveedor->direccion ?? '-' }}</dd>
                <dt class="col-sm-3">Línea de crédito</dt>
                <dd class="col-sm-9">${{ number_format($proveedor->linea_credito,2) }}</dd>
                <dt class="col-sm-3">Tiempo de crédito</dt>
                <dd class="col-sm-9">{{ $proveedor->tiempo_credito ?? '-' }} días</dd>
                <dt class="col-sm-3">Métodos de entrega</dt>
                <dd class="col-sm-9">{{ $proveedor->metodos_entrega ?? '-' }}</dd>
                <dt class="col-sm-3">Categoría</dt>
                <dd class="col-sm-9">{{ $proveedor->categoria ?? '-' }}</dd>
                <dt class="col-sm-3">Tipo de proveedor</dt>
                <dd class="col-sm-9">{{ $proveedor->tipo ?? '-' }}</dd>
                <dt class="col-sm-3">Método de pago</dt>
                <dd class="col-sm-9">{{ $proveedor->metodo_pago ?? '-' }}</dd>
                <dt class="col-sm-3">¿Factura?</dt>
                <dd class="col-sm-9">
                    @if($proveedor->factura)
                        <span class="badge bg-success">Sí</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </dd>
                <dt class="col-sm-3">Comentarios</dt>
                <dd class="col-sm-9">{{ $proveedor->comentarios ?? '-' }}</dd>
            </dl>
        </div>
        <div class="card-footer text-end">
            <form method="POST" action="{{ route('proveedores.destroy', $proveedor) }}" style="display:inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar proveedor?')">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('proveedores.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>
</div>
@endsection
