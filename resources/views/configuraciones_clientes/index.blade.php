@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Configuraciones Técnicas del Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b></h2>
    <a href="{{ route('servicios_empresariales.configuraciones_clientes.create', $servicio->id) }}" class="btn btn-primary mb-2">Nueva configuración</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Dato</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($configuraciones as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->cliente->nombre ?? '' }}</td>
                <td>{{ $c->tipo }}</td>
                <td>{{ $c->descripcion }}</td>
                <td>{{ $c->dato }}</td>
                <td>
                    <a href="{{ route('servicios_empresariales.configuraciones_clientes.show', [$servicio->id, $c->id]) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('servicios_empresariales.configuraciones_clientes.edit', [$servicio->id, $c->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('servicios_empresariales.configuraciones_clientes.destroy', [$servicio->id, $c->id]) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
