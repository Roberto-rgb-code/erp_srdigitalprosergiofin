@extends('layouts.app')
@section('content')
<h2>Configuraciones Técnicas</h2>
<a href="{{ route('configuraciones_clientes.create') }}" class="btn btn-primary mb-2">Nueva configuración</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Cliente</th><th>Tipo</th><th>Descripción</th><th>Dato</th><th>Acciones</th>
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
                <a href="{{ route('configuraciones_clientes.show', $c) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('configuraciones_clientes.edit', $c) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('configuraciones_clientes.destroy', $c) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
