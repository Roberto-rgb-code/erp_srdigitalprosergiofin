@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Usuarios de Póliza (Servicio #{{ $servicio->id }})</h1>
    <a href="{{ route('usuarios_poliza.create', $servicio->id) }}" class="btn btn-primary mb-3">Agregar Usuario</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Comentarios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->correo }}</td>
                <td>{{ $usuario->rol }}</td>
                <td>{{ $usuario->comentarios }}</td>
                <td>
                    <a href="{{ route('usuarios_poliza.edit', [$servicio->id, $usuario->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('usuarios_poliza.destroy', [$servicio->id, $usuario->id]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Eliminar usuario?')" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $usuarios->links() }}
    <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary mt-3">Volver a Servicios Empresariales</a>
</div>
@endsection
