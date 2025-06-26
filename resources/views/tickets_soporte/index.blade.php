@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Tickets de Soporte (Servicio #{{ $servicio->id }})</h1>
    <a href="{{ route('tickets_soporte.create', $servicio->id) }}" class="btn btn-primary mb-3">Nuevo Ticket</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Fecha Apertura</th>
                <th>Fecha Cierre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->titulo }}</td>
                <td>{{ $ticket->estado }}</td>
                <td>{{ $ticket->prioridad }}</td>
                <td>{{ $ticket->fecha_apertura->format('Y-m-d') }}</td>
                <td>{{ $ticket->fecha_cierre ? $ticket->fecha_cierre->format('Y-m-d') : '-' }}</td>
                <td>
                    <a href="{{ route('tickets_soporte.edit', [$servicio->id, $ticket->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('tickets_soporte.destroy', [$servicio->id, $ticket->id]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Eliminar ticket?')" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tickets->links() }}

    <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary mt-3">Volver a Servicios Empresariales</a>
</div>
@endsection
