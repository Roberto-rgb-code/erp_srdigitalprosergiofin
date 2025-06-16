@extends('layouts.app')
@section('content')
<h2>Usuarios del Cliente</h2>
<a href="{{ route('usuarios_clientes.create') }}" class="btn btn-primary mb-2">Nuevo Usuario</a>
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
                <a href="{{ route('usuarios_clientes.show', $u) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('usuarios_clientes.edit', $u) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('usuarios_clientes.destroy', $u) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
