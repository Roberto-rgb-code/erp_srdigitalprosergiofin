@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Usuarios del Cliente (Servicio: {{ $servicio->id }})</h2>
    <a href="{{ route('servicios_empresariales.usuarios_clientes.create', $servicio->id) }}" class="btn btn-primary mb-3">Agregar Usuario</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th><th>Rol</th><th>Usuario</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->rol }}</td>
                    <td>{{ $usuario->usuario }}</td>
                    <td>
                        <a href="{{ route('servicios_empresariales.usuarios_clientes.edit', [$servicio->id, $usuario->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('servicios_empresariales.usuarios_clientes.destroy', [$servicio->id, $usuario->id]) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
