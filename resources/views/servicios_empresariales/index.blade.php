@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Servicios Empresariales</h1>

    <a href="{{ route('servicios_empresariales.create') }}" class="btn btn-primary mb-3">Nuevo Servicio</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Tipo Póliza</th>
                <th>Estatus</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id }}</td>
                    <td>{{ $servicio->cliente->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $servicio->tipo_poliza }}</td>
                    <td>{{ $servicio->estatus }}</td>
                    <td>{{ $servicio->fecha_inicio }}</td>
                    <td>{{ $servicio->fecha_fin ?? '-' }}</td>
                    <td>
                        <a href="{{ route('servicios_empresariales.show', $servicio) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('servicios_empresariales.edit', $servicio) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('servicios_empresariales.destroy', $servicio) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Eliminar servicio?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $servicios->links() }}
</div>
@endsection
