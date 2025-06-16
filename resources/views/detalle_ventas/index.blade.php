@extends('layouts.app')
@section('content')
    <h2>Detalle de Venta #{{ $venta->id }} ({{ $venta->cliente->nombre ?? '' }})</h2>
    
    <a href="{{ route('ventas.detalle_ventas.create', $venta->id) }}" class="btn btn-primary mb-3">Agregar Producto/Servicio</a>
    <a href="{{ route('ventas.detalle_ventas.export.excel', $venta->id) }}" class="btn btn-success mb-3">Exportar Excel</a>
    <a href="{{ route('ventas.detalle_ventas.export.pdf', $venta->id) }}" class="btn btn-danger mb-3">Exportar PDF</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto o Servicio</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($venta->detalles as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->producto_servicio }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td>${{ number_format($d->precio_unitario, 2) }}</td>
                    <td>${{ number_format($d->subtotal, 2) }}</td>
                    <td>
                        <a href="{{ route('ventas.detalle_ventas.edit', [$venta->id, $d->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('ventas.detalle_ventas.destroy', [$venta->id, $d->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay detalles para esta venta.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Regresar a ventas</a>
@endsection
