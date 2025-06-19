@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Pólizas Contables</h2>
    <a href="{{ route('polizas_contables.create') }}" class="btn btn-primary mb-3">Nueva Póliza</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($polizas as $p)
            <tr>
                <td>{{ $p->tipo }}</td>
                <td>{{ $p->fecha }}</td>
                <td>{{ $p->descripcion }}</td>
                <td>
                    <a href="{{ route('polizas_contables.show', $p) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('polizas_contables.edit', $p) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('polizas_contables.destroy', $p) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('¿Eliminar?')" class="btn btn-danger btn-sm">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
