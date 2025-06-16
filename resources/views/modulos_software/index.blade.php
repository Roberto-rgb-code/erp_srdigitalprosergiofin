@extends('layouts.app')
@section('content')
    <h3>Módulos de: {{ $proyecto->nombre }}</h3>
    <a href="{{ route('modulos_software.create', $proyecto->id) }}" class="btn btn-primary mb-2">Agregar módulo</a>
    <a href="{{ route('desarrollo_software.show', $proyecto->id) }}" class="btn btn-secondary mb-2">Regresar al proyecto</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Avance (%)</th>
                <th>Fase</th>
                <th>Entregas</th>
                <th>Feedback</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modulos as $m)
                <tr>
                    <td>{{ $m->nombre }}</td>
                    <td>{{ $m->porcentaje_avance }}</td>
                    <td>{{ $m->fase }}</td>
                    <td><a href="{{ route('modulos_software.entregas.index', [$proyecto->id, $m->id]) }}" class="btn btn-outline-success btn-sm">Entregas</a></td>
                    <td><a href="{{ route('modulos_software.feedback.index', [$proyecto->id, $m->id]) }}" class="btn btn-outline-info btn-sm">Feedback</a></td>
                    <td>
                        <a href="{{ route('modulos_software.edit', [$proyecto->id, $m->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('modulos_software.destroy', [$proyecto->id, $m->id]) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
