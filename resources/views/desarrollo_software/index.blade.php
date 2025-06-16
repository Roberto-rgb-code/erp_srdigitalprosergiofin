@extends('layouts.app')
@section('content')
    <h2>Proyectos de Desarrollo de Software</h2>
    <a href="{{ route('desarrollo_software.create') }}" class="btn btn-primary mb-2">Nuevo proyecto</a>
    <a href="{{ route('desarrollo_software.exportExcel') }}" class="btn btn-outline-success mb-2">Exportar Excel</a>
    <a href="{{ route('desarrollo_software.exportPDF') }}" class="btn btn-outline-danger mb-2">Exportar PDF</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Entrega</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyectos as $p)
                <tr>
                    <td><a href="{{ route('desarrollo_software.show', $p) }}">{{ $p->nombre }}</a></td>
                    <td>{{ $p->cliente->nombre ?? '-' }}</td>
                    <td>{{ $p->tipoSoftware->nombre ?? '-' }}</td>
                    <td>{{ $p->responsable->nombre ?? '-' }}</td>
                    <td>{{ $p->estado }}</td>
                    <td>{{ $p->fecha_inicio }}</td>
                    <td>{{ $p->fecha_fin }}</td>
                    <td>
                        <a href="{{ route('desarrollo_software.edit', $p) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('desarrollo_software.destroy', $p) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $proyectos->links() }}
@endsection
