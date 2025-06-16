@extends('layouts.app')
@section('content')
    <h2>Clientes</h2>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Nuevo Cliente</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="row g-2 mb-3" method="GET">
        <div class="col">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}">
        </div>
        <div class="col">
            <input type="text" name="rfc" class="form-control" placeholder="RFC" value="{{ request('rfc') }}">
        </div>
        <div class="col">
            <select name="status" class="form-select">
                <option value="">Estatus</option>
                <option value="Activo" @selected(request('status')=='Activo')>Activo</option>
                <option value="Inactivo" @selected(request('status')=='Inactivo')>Inactivo</option>
            </select>
        </div>
        <div class="col">
            <button class="btn btn-secondary">Buscar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
        <div class="col">
            <a href="{{ route('clientes.export.excel', request()->all()) }}" class="btn btn-success">Exportar Excel</a>
            <a href="{{ route('clientes.export.pdf', request()->all()) }}" class="btn btn-danger">Exportar PDF</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Nombre</th>
                <th>RFC</th>
                <th>Dirección</th>
                <th>Contacto</th>
                <th>Tipo</th>
                <th>Límite crédito</th>
                <th>Saldo</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $c)
                <tr>
                    <td>{{ $c->folio }}</td>
                    <td><a href="{{ route('clientes.show', $c) }}">{{ $c->nombre }}</a></td>
                    <td>{{ $c->rfc }}</td>
                    <td>{{ $c->direccion }}</td>
                    <td>{{ $c->contacto }}</td>
                    <td>{{ $c->tipo_cliente }}</td>
                    <td>${{ number_format($c->limite_credito,2) }}</td>
                    <td>${{ number_format($c->saldo,2) }}</td>
                    <td>{{ $c->status }}</td>
                    <td>
                        <a href="{{ route('clientes.edit', $c) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('clientes.destroy', $c) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="10">No hay clientes.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $clientes->links() }}
@endsection
