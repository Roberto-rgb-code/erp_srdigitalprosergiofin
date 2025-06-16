@extends('layouts.app')

@section('content')
    <h2>Inventario de Equipos</h2>

    {{-- Botón para crear un nuevo equipo, sólo si tienes el id del servicio empresarial --}}
    @if(isset($servicioEmpresarial))
        <a href="{{ route('servicios_empresariales.inventarios.create', $servicioEmpresarial->id) }}" class="btn btn-primary mb-3">Nuevo equipo</a>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Servicio Empresarial</th>
                <th>Cliente</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipos as $e)
                <tr>
                    <td>{{ $e->id }}</td>
                    <td>{{ $e->servicioEmpresarial->id ?? '-' }}</td>
                    <td>{{ $e->cliente->nombre ?? '-' }}</td>
                    <td>{{ $e->nombre_equipo }}</td>
                    <td>{{ $e->tipo_equipo }}</td>
                    <td>{{ $e->modelo }}</td>
                    <td>{{ $e->serie }}</td>
                    <td>
                        <a href="{{ route('servicios_empresariales.inventarios.edit', [$e->servicio_empresarial_id, $e->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('servicios_empresariales.inventarios.destroy', [$e->servicio_empresarial_id, $e->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @if($equipos->isEmpty())
                <tr><td colspan="8">No hay equipos registrados.</td></tr>
            @endif
        </tbody>
    </table>
@endsection
