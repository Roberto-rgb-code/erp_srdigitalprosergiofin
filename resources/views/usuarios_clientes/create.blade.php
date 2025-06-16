@extends('layouts.app')
@section('content')
<h2>Nuevo Usuario de Cliente</h2>
<form action="{{ route('usuarios_clientes.store') }}" method="POST">
    @csrf
    <div class="mb-2">
        <label>Cliente:</label>
        <select name="cliente_id" class="form-select" required>
            @foreach($clientes as $c)
                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Nombre de usuario:</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Rol:</label>
        <input type="text" name="rol" class="form-control">
    </div>
    <div class="mb-2">
        <label>Contraseña:</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('usuarios_clientes.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
