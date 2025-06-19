@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Usuarios del Cliente — Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b></h2>

    <a href="{{ route('servicios_empresariales.usuarios_clientes.create', $servicio->id) }}" class="btn btn-primary mb-2">
        Nuevo Usuario
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Cliente</th><th>Nombre</th><th>Rol</th><th>Usuario</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usuarios as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->cliente->nombre ?? '' }}</td>
                <td>{{ $u->nombre }}</td>
                <td>{{ $u->rol }}</td>
                <td>{{ $u->usuario }}</td>
                <td>
                    <a href="{{ route('servicios_empresariales.usuarios_clientes.show', [$servicio->id, $u->id]) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('servicios_empresariales.usuarios_clientes.edit', [$servicio->id, $u->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('servicios_empresariales.usuarios_clientes.destroy', [$servicio->id, $u->id]) }}" method="POST" style="display:inline;">
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
