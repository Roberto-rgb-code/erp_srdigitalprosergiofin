@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Inventario de Equipos para Servicio #{{ $servicio->id }}</h1>
    <a href="{{ route('inventario_equipos.create', $servicio->id) }}" class="btn btn-primary mb-3">Agregar Equipo</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Número Serie</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarios as $inv)
            <tr>
                <td>{{ $inv->id }}</td>
                <td>{{ $inv->tipo_equipo }}</td>
                <td>{{ $inv->marca }}</td>
                <td>{{ $inv->modelo }}</td>
                <td>{{ $inv->numero_serie }}</td>
                <td>{{ $inv->estado }}</td>
                <td>
                    <a href="{{ route('inventario_equipos.edit', [$servicio->id, $inv->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('inventario_equipos.destroy', [$servicio->id, $inv->id]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Eliminar equipo?')" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $inventarios->links() }}
    <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary mt-3">Volver a Servicios Empresariales</a>
</div>
@endsection
