@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Compras</h3>
    <a href="{{ route('compras.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Compra
    </a>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>Proveedor</th>
            <th>Descripción</th>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Método de pago</th>
            <th>Factura</th>
            <th style="width: 180px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
    @forelse($compras as $compra)
        <tr>
            <td>{{ $compra->proveedor }}</td>
            <td>{{ $compra->descripcion }}</td>
            <td>${{ number_format($compra->monto, 2) }}</td>
            <td>{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
            <td>{{ ucfirst($compra->metodo_pago) }}</td>
            <td>
                @if($compra->factura) <span class="badge bg-success">Sí</span>
                @else <span class="badge bg-secondary">No</span>
                @endif
            </td>
            <td>
                <a href="{{ route('compras.show', $compra) }}" class="btn btn-sm btn-outline-primary me-1" title="Ver">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('compras.edit', $compra) }}" class="btn btn-sm btn-outline-warning me-1" title="Editar">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('compras.destroy', $compra) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('¿Eliminar esta compra?')"
                        title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center">No hay compras registradas.</td></tr>
    @endforelse
    </tbody>
</table>
{{ $compras->links() }}
@endsection
