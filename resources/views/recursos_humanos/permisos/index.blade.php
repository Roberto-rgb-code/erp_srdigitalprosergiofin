@extends('layouts.app')
@section('content')
<h2>Permisos de {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<a href="{{ route('recursos_humanos.permisos.create', $empleado) }}" class="btn btn-primary mb-2">Nuevo permiso</a>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Motivo</th>
            <th>Aprobado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permisos as $p)
        <tr>
            <td>{{ $p->fecha_inicio }}</td>
            <td>{{ $p->fecha_fin }}</td>
            <td>{{ $p->motivo }}</td>
            <td>{{ $p->aprobado ? 'Sí' : 'No' }}</td>
            <td>
                <a href="{{ route('recursos_humanos.permisos.edit', [$empleado, $p]) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('recursos_humanos.permisos.destroy', [$empleado, $p]) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Eliminar?')" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('recursos_humanos.show', $empleado) }}" class="btn btn-secondary">Regresar</a>
@endsection
