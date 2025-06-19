@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Usuario del Cliente (Servicio: <b>{{ $servicio->poliza ?? $servicio->id }}</b>)</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servicios_empresariales.usuarios_clientes.update', [$servicio->id, $usuario->id]) }}" method="POST" class="card p-4 shadow">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $usuario->cliente_id) == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del usuario</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required value="{{ old('nombre', $usuario->nombre) }}">
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <input type="text" name="rol" id="rol" class="form-control" value="{{ old('rol', $usuario->rol) }}">
        </div>
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario (login)</label>
            <input type="text" name="usuario" id="usuario" class="form-control" required value="{{ old('usuario', $usuario->usuario) }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña (solo si deseas cambiarla)</label>
            <input type="password" name="password" id="password" class="form-control">
            <div class="form-text">Déjalo vacío si no deseas cambiarla</div>
        </div>
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('servicios_empresariales.usuarios_clientes.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
