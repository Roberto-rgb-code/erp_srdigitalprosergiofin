@extends('layouts.app')
@section('content')
<h2>Editar Usuario del Cliente</h2>
@if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form action="{{ route('usuarios_clientes.update', $usuarios_cliente) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2"><label>Cliente:</label>
        <select name="cliente_id" class="form-control">
            @foreach($clientes as $c)
                <option value="{{ $c->id }}" @if($c->id == $usuarios_cliente->cliente_id) selected @endif>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Nombre:</label><input name="nombre" class="form-control" value="{{ $usuarios_cliente->nombre }}"></div>
    <div class="mb-2"><label>Rol:</label><input name="rol" class="form-control" value="{{ $usuarios_cliente->rol }}"></div>
    <div class="mb-2"><label>Usuario:</label><input name="usuario" class="form-control" value="{{ $usuarios_cliente->usuario }}"></div>
    <div class="mb-2"><label>Nueva Contraseña:</label>
        <input name="password" type="password" class="form-control" placeholder="Dejar vacío para no cambiar">
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('usuarios_clientes.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
