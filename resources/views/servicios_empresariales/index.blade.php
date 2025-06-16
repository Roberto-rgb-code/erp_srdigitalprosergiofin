@extends('layouts.app')

@section('content')
    <h2>Servicios Empresariales</h2>

    <a href="{{ route('servicios_empresariales.create') }}" class="btn btn-primary mb-2">Nuevo Servicio Empresarial</a>
    <a href="{{ route('servicios_empresariales.export.excel') }}" class="btn btn-success mb-2">Exportar Excel</a>
    <a href="{{ route('servicios_empresariales.export.pdf') }}" class="btn btn-danger mb-2">Exportar PDF</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Póliza</th>
                <th>Estatus</th>
                <th>Comentarios</th>
                <th>Acciones</th>
                <th>Submódulos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id }}</td>
                    <td>{{ $servicio->cliente->nombre ?? '-' }}</td>
                    <td>{{ $servicio->poliza ?? '-' }}</td>
                    <td>{{ $servicio->estatus }}</td>
                    <td>{{ $servicio->comentarios }}</td>
                    <td>
                        <a href="{{ route('servicios_empresariales.edit', $servicio) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('servicios_empresariales.destroy', $servicio) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group flex-wrap">
                            <a href="{{ route('servicios_empresariales.inventarios.index', $servicio->id) }}" class="btn btn-sm btn-secondary mb-1">Inventario</a>
                            <a href="{{ route('servicios_empresariales.usuarios_clientes.index', $servicio->id) }}" class="btn btn-sm btn-info mb-1">Usuarios</a>
                            <a href="{{ route('servicios_empresariales.configuraciones_clientes.index', $servicio->id) }}" class="btn btn-sm btn-warning mb-1">Configuraciones</a>
                            <a href="{{ route('servicios_empresariales.tickets_soporte.index', $servicio->id) }}" class="btn btn-sm btn-success mb-1">Tickets</a>
                            <a href="{{ route('servicios_empresariales.seguimientos_ticket.index', $servicio->id) }}" class="btn btn-sm btn-primary mb-1">Seguimiento</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay servicios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $servicios->links() }}
@endsection
