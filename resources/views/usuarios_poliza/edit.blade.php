@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Editar Usuario (ID {{ $usuario->id }})</h1>

    <form action="{{ route('usuarios_poliza.update', [$servicio->id, $usuario->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $usuario->nombre) }}" required>
            @error('nombre') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ old('correo', $usuario->correo) }}" required>
            @error('correo') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Nueva Contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
            <small class="text-muted">Deja vacío para mantener la contraseña actual.</small>
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Rol</label>
            <input type="text" name="rol" class="form-control" value="{{ old('rol', $usuario->rol) }}">
        </div>

        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios', $usuario->comentarios) }}</textarea>
        </div>

        <button class="btn btn-primary" type="submit">Actualizar</button>
        <a href="{{ route('usuarios_poliza.index', $servicio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
