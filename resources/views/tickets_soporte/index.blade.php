@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tickets de Soporte — Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b></h2>
    <a href="{{ route('servicios_empresariales.tickets_soporte.create', $servicio->id) }}" class="btn btn-primary mb-2">Nuevo Ticket</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Título</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tickets as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->cliente->nombre ?? '' }}</td>
                <td>{{ $t->titulo }}</td>
                <td>{{ $t->estatus }}</td>
                <td>
                    <a href="{{ route('servicios_empresariales.tickets_soporte.show', [$servicio->id, $t->id]) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('servicios_empresariales.tickets_soporte.edit', [$servicio->id, $t->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('servicios_empresariales.tickets_soporte.destroy', [$servicio->id, $t->id]) }}" method="POST" style="display:inline;">
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
