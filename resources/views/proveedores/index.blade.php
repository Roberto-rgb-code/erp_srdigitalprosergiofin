@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Proveedores</h2>
    <a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus"></i> Nuevo Proveedor
    </a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ejecutivo</th>
                <th>Teléfono</th>
                <th>Línea de crédito</th>
                <th>Tipo</th>
                <th>Factura</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proveedores as $prv)
                <tr>
                    <td>{{ $prv->nombre }}</td>
                    <td>{{ $prv->ejecutivo_venta }}</td>
                    <td>{{ $prv->telefono }}</td>
                    <td>${{ number_format($prv->linea_credito,2) }}</td>
                    <td>{{ $prv->tipo }}</td>
                    <td>
                        @if($prv->factura)
                            <span class="badge bg-success">Sí</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('proveedores.show', $prv) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('proveedores.edit', $prv) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('proveedores.destroy', $prv) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar proveedor?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No hay proveedores registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $proveedores->links() }}
</div>
@endsection
