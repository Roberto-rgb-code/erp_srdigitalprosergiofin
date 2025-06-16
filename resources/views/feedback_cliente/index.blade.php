@extends('layouts.app')
@section('content')
    <h3>Feedback cliente del módulo: {{ $modulo->nombre }}</h3>
    <form action="{{ route('modulos_software.feedback.store', [$proyecto, $modulo->id]) }}" method="POST" class="mb-2">
        @csrf
        <div class="input-group">
            <input type="text" name="comentario" class="form-control" placeholder="Escribe un comentario..." required>
            <button class="btn btn-success">Agregar</button>
        </div>
    </form>
    <a href="{{ route('modulos_software.index', $proyecto) }}" class="btn btn-secondary mb-2">Regresar a módulos</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $f)
                <tr>
                    <td>{{ $f->comentario }}</td>
                    <td>{{ $f->fecha }}</td>
                    <td>
                        <form action="{{ route('modulos_software.feedback.destroy', [$proyecto, $modulo->id, $f->id]) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
