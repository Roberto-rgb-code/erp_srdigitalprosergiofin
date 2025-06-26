@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inventario de Clientes</h2>

    <a href="{{ route('inventario_clientes.create') }}" class="btn btn-success mb-3">Nuevo Inventario</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Servicio Empresarial</th>
                <th>Cliente</th>
                <th>Poliza</th>
                <th>Nombre Equipo</th>
                <th>Descripción</th>
                <th>Número Serie</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarios as $inv)
                <tr>
                    <td>{{ $inv->id }}</td>
                    <td>{{ $inv->servicio->id ?? 'N/A' }}</td>
                    <td>{{ $inv->servicio->cliente->nombre ?? 'N/A' }}</td>
                    <td>{{ $inv->servicio->poliza ?? 'N/A' }}</td>
                    <td>{{ $inv->nombre_equipo }}</td>
                    <td>{{ $inv->descripcion }}</td>
                    <td>{{ $inv->numero_serie }}</td>
                    <td>
                        <a href="{{ route('inventario_clientes.edit', $inv) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('inventario_clientes.destroy', $inv) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar inventario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $inventarios->links() }}
</div>
@endsection
