@extends('layouts.app')
@section('content')
    <h2>Órdenes de Servicio</h2>
    <div class="mb-3 d-flex gap-2 flex-wrap">
        <a href="{{ route('taller.create') }}" class="btn btn-primary">Nueva Orden</a>
        <a href="{{ route('taller.export.excel') }}" class="btn btn-success">Exportar Excel</a>
        <a href="{{ route('taller.export.pdf') }}" class="btn btn-danger">Exportar PDF</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h5 class="mt-4">Órdenes de Servicio Registradas</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Tipo cliente</th>
                <th>Equipo</th>
                <th>IMEI/Serie</th>
                <th>Técnico</th>
                <th>Ingreso</th>
                <th>Entrega</th>
                <th>Estatus</th>
                <th>Costo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($talleres as $t)
                <tr>
                    <td>{{ $t->folio }}</td>
                    <td>{{ $t->cliente->nombre ?? '-' }}</td>
                    <td>{{ $t->tipo_cliente }}</td>
                    <td>
                        {{ $t->equipo->tipo ?? '-' }}
                        {{ $t->equipo->marca ?? '' }}
                        {{ $t->equipo->modelo ?? '' }}
                    </td>
                    <td>{{ $t->equipo->imei ?? '' }}</td>
                    <td>{{ $t->tecnico->nombre ?? '-' }}</td>
                    <td>{{ $t->fecha_ingreso }}</td>
                    <td>{{ $t->fecha_entrega }}</td>
                    <td>{{ $t->status }}</td>
                    <td>${{ number_format($t->costo_total,2) }}</td>
                    <td>
                        <a href="{{ route('taller.show', $t) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('taller.edit', $t) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('taller.destroy', $t) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11">No hay órdenes registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $talleres->links() }}

    <h5 class="mt-5">Catálogo de Equipos</h5>
    <a href="{{ route('equipos.create') }}" class="btn btn-outline-primary mb-2">Registrar nuevo equipo</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Color</th>
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
                    <td>{{ $e->color }}</td>
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
                <tr><td colspan="10">Sin equipos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $equipos->links() }}
@endsection
