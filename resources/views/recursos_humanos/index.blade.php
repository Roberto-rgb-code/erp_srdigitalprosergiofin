@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h2>Empleados</h2>
    <a href="{{ route('recursos_humanos.create') }}" class="btn btn-primary">Nuevo empleado</a>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre completo</th>
            <th>Puesto</th>
            <th>Fecha ingreso</th>
            <th>Estatus</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($empleados as $e)
            <tr>
                <td>{{ $e->id }}</td>
                <td>
                    <a href="{{ route('recursos_humanos.show', $e) }}">
                        {{ $e->nombre }} {{ $e->apellido }}
                    </a>
                </td>
                <td>{{ $e->puesto->nombre ?? '-' }}</td>
                <td>{{ $e->fecha_ingreso }}</td>
                <td>{{ $e->status }}</td>
                <td>
                    <a href="{{ route('recursos_humanos.edit', $e) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('recursos_humanos.destroy', $e) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('¿Eliminar?')" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $empleados->links() }}
@endsection
