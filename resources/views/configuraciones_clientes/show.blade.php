@extends('layouts.app')
@section('content')
<h2>Detalle de Configuración Técnica</h2>
<table class="table">
    <tr><th>ID</th><td>{{ $configuraciones_cliente->id }}</td></tr>
    <tr><th>Cliente</th><td>{{ $configuraciones_cliente->cliente->nombre ?? '' }}</td></tr>
    <tr><th>Tipo</th><td>{{ $configuraciones_cliente->tipo }}</td></tr>
    <tr><th>Descripción</th><td>{{ $configuraciones_cliente->descripcion }}</td></tr>
    <tr><th>Dato</th><td>{{ $configuraciones_cliente->dato }}</td></tr>
</table>
<a href="{{ route('configuraciones_clientes.edit', $configuraciones_cliente) }}" class="btn btn-warning">Editar</a>
<a href="{{ route('configuraciones_clientes.index') }}" class="btn btn-secondary">Volver</a>
@endsection
