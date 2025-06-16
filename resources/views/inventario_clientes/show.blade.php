@extends('layouts.app')
@section('content')
<h2>Detalle de Equipo</h2>
<table class="table">
    <tr><th>ID</th><td>{{ $inventario_cliente->id }}</td></tr>
    <tr><th>Cliente</th><td>{{ $inventario_cliente->cliente->nombre ?? '' }}</td></tr>
    <tr><th>Nombre equipo</th><td>{{ $inventario_cliente->nombre_equipo }}</td></tr>
    <tr><th>Tipo equipo</th><td>{{ $inventario_cliente->tipo_equipo }}</td></tr>
    <tr><th>Modelo</th><td>{{ $inventario_cliente->modelo }}</td></tr>
    <tr><th>Número de serie</th><td>{{ $inventario_cliente->serie }}</td></tr>
    <tr><th>Ubicación</th><td>{{ $inventario_cliente->ubicacion }}</td></tr>
</table>
<a href="{{ route('inventario_clientes.edit', $inventario_cliente) }}" class="btn btn-warning">Editar</a>
<a href="{{ route('inventario_clientes.index') }}" class="btn btn-secondary">Volver</a>
@endsection
