@extends('layouts.app')
@section('content')
    <h2>Catálogo de Equipos</h2>
    <a href="{{ route('equipos.create') }}" class="btn btn-primary mb-3">Nuevo equipo</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>IMEI/Serie</th>
                <th>Condición</th>
                <th>Estética</th>
                <th>Zona</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $e)
                <tr>
                    <td>{{ $e->id }}</td>
                    <td>{{ $e->tipo }}</td>
                    <td>{{ $e->marca }}</td>
                    <td>{{ $e->modelo }}</td>
                    <td>{{ $e->imei }}</td>
                    <td>{{ $e->condicion_fisica }}</td>
                    <td>{{ $e->estetica }}</td>
                    <td>{{ $e->zona_trabajo }}</td>
                    <td>
                        <a href="{{ route('equipos.show', $e) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('equipos.edit', $e) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('equipos.destroy', $e) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">Sin registros.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $equipos->links() }}
@endsection
