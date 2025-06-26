@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Gastos Fijos</h2>
    <a href="{{ route('gastos_fijos.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus"></i> Nuevo Gasto Fijo
    </a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Nombre del Gasto</th>
                <th>Monto Mensual</th>
                <th>Vencimiento</th>
                <th>Categoría</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gastos as $gasto)
                <tr>
                    <td>{{ $gasto->proveedor->nombre ?? '-' }}</td>
                    <td>{{ $gasto->nombre_gasto }}</td>
                    <td>${{ number_format($gasto->monto,2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($gasto->fecha_vencimiento)->format('d/m/Y') }}</td>
                    <td>{{ $gasto->categoria }}</td>
                    <td>
                        @if($gasto->pagado)
                            <span class="badge bg-success">Pagado</span>
                        @else
                            <span class="badge bg-danger">Pendiente</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('gastos_fijos.show', $gasto) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('gastos_fijos.edit', $gasto) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('gastos_fijos.destroy', $gasto) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar gasto?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No hay gastos fijos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $gastos->links() }}
</div>
@endsection
