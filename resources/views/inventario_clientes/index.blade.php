@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Inventario de Equipos de Clientes</h2>
        <a href="{{ route('inventario_clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Registro
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Equipo</th>
                    <th>Tipo</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->id }}</td>
                        <td>{{ $equipo->cliente->nombre ?? '-' }}</td>
                        <td>{{ $equipo->nombre_equipo }}</td>
                        <td>{{ $equipo->tipo_equipo }}</td>
                        <td>{{ $equipo->modelo }}</td>
                        <td>{{ $equipo->serie }}</td>
                        <td>
                            <a href="{{ route('inventario_clientes.show', $equipo) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('inventario_clientes.edit', $equipo) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('inventario_clientes.destroy', $equipo) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay equipos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
