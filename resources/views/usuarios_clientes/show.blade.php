@extends('layouts.app')
@section('content')
<h2>Detalle de Usuario del Cliente</h2>
<table class="table">
    <tr><th>ID</th><td>{{ $usuarios_cliente->id }}</td></tr>
    <tr><th>Cliente</th><td>{{ $usuarios_cliente->cliente->nombre ?? '' }}</td></tr>
    <tr><th>Nombre</th><td>{{ $usuarios_cliente->nombre }}</td></tr>
    <tr><th>Rol</th><td>{{ $usuarios_cliente->rol }}</td></tr>
    <tr><th>Usuario</th><td>{{ $usuarios_cliente->usuario }}</td></tr>
    <tr><th>Contraseña</th><td>******</td></tr>
</table>
<a href="{{ route('usuarios_clientes.edit', $usuarios_cliente) }}" class="btn btn-warning">Editar</a>
<a href="{{ route('usuarios_clientes.index') }}" class="btn btn-secondary">Volver</a>
@endsection
