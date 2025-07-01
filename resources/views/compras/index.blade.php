@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Compras</h2>

    <a href="{{ route('compras.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Nueva Compra
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Método Pago</th>
                <th>Factura</th>
                <th>Acciones</th>
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
                    {!! $compra->factura
                        ? '<span class="badge bg-success">Sí</span>'
                        : '<span class="badge bg-secondary">No</span>' !!}
                </td>
                <td>
                    <a href="{{ route('compras.show', $compra) }}" class="btn btn-sm btn-info me-1" title="Ver">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('compras.edit', $compra) }}" class="btn btn-sm btn-warning me-1" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('compras.destroy', $compra) }}" method="POST" class="d-inline">
                        @csrf 
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta compra?')" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No hay compras registradas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $compras->links() }}
</div>
@endsection
