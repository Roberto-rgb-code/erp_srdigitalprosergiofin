@extends('layouts.app')
@section('content')
<h2>Pólizas de Servicio</h2>
<a href="{{ route('polizas_servicio.create') }}" class="btn btn-primary mb-2">Nueva Póliza</a>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Cliente</th><th>Tipo</th><th>Remotos</th><th>Domicilio</th><th>Estado</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($polizas as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->cliente->nombre ?? '' }}</td>
            <td>{{ $p->tipo }}</td>
            <td>{{ $p->servicios_remotos_restantes }}/{{ $p->servicios_remotos }}</td>
            <td>{{ $p->servicios_domicilio_restantes }}/{{ $p->servicios_domicilio }}</td>
            <td>{{ $p->estatus }}</td>
            <td>
                <a href="{{ route('polizas_servicio.show', $p) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('polizas_servicio.edit', $p) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('polizas_servicio.destroy', $p) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
