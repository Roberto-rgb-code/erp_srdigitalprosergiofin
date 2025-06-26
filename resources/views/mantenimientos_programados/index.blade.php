@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Mantenimientos Programados (Servicio #{{ $servicio->id }})</h1>
    <a href="{{ route('mantenimientos_programados.create', $servicio->id) }}" class="btn btn-primary mb-3">Nuevo Mantenimiento</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Fecha Programada</th>
                <th>Estado</th>
                <th>Comentarios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mantenimientos as $mantenimiento)
            <tr>
                <td>{{ $mantenimiento->id }}</td>
                <td>{{ $mantenimiento->descripcion }}</td>
                <td>{{ $mantenimiento->fecha_programada->format('Y-m-d') }}</td>
                <td>{{ $mantenimiento->estado }}</td>
                <td>{{ $mantenimiento->comentarios }}</td>
                <td>
                    <a href="{{ route('mantenimientos_programados.edit', [$servicio->id, $mantenimiento->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('mantenimientos_programados.destroy', [$servicio->id, $mantenimiento->id]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Eliminar mantenimiento?')" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $mantenimientos->links() }}

    <a href="{{ route('servicios_empresariales.index') }}" class="btn btn-secondary mt-3">Volver a Servicios Empresariales</a>
</div>
@endsection
