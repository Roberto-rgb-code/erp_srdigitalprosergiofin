@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Configuraciones del Cliente (Servicio #{{ $servicio->id }})</h2>
    <a href="{{ route('servicios_empresariales.configuraciones_clientes.create', $servicio->id) }}" class="btn btn-primary mb-3">Agregar Configuración</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <table class="table">
        <thead>
            <tr>
                <th>Tipo</th><th>Descripción</th><th>Dato</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($configuraciones as $conf)
            <tr>
                <td>{{ $conf->tipo }}</td>
                <td>{{ $conf->descripcion }}</td>
                <td>{{ $conf->dato }}</td>
                <td>
                    <a href="{{ route('servicios_empresariales.configuraciones_clientes.edit', [$servicio->id, $conf->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('servicios_empresariales.configuraciones_clientes.destroy', [$servicio->id, $conf->id]) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar configuración?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
