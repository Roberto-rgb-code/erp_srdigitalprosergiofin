@extends('layouts.app')
@section('content')
<h2>Asistencias de {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
<a href="{{ route('recursos_humanos.asistencias.create', $empleado) }}" class="btn btn-primary mb-2">Nueva asistencia</a>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Fecha</th><th>Tipo</th><th>Motivo</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($asistencias as $a)
        <tr>
            <td>{{ $a->fecha }}</td>
            <td>{{ $a->tipo }}</td>
            <td>{{ $a->motivo }}</td>
            <td>
                <a href="{{ route('recursos_humanos.asistencias.edit', [$empleado, $a]) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('recursos_humanos.asistencias.destroy', [$empleado, $a]) }}" method="POST" style="display:inline-block">
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
