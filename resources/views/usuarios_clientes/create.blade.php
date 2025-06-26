@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Agregar Usuario a Servicio Empresarial #{{ $servicio->id }}</h2>
    <form action="{{ route('servicios_empresariales.usuarios_clientes.store', $servicio->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Rol</label>
            <input type="text" name="rol" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Usuario</label>
            <input type="text" name="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('servicios_empresariales.usuarios_clientes.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
