@extends('layouts.app')
@section('content')
    <h2>Editar Equipo</h2>
    <form method="POST" action="{{ route('equipos.update', $equipo) }}">
        @csrf
        @method('PUT')
        <div class="mb-3"><label>Tipo</label>
            <input type="text" name="tipo" value="{{ old('tipo', $equipo->tipo) }}" class="form-control" required>
        </div>
        <div class="mb-3"><label>Marca</label>
            <input type="text" name="marca" value="{{ old('marca', $equipo->marca) }}" class="form-control">
        </div>
        <div class="mb-3"><label>Modelo</label>
            <input type="text" name="modelo" value="{{ old('modelo', $equipo->modelo) }}" class="form-control">
        </div>
        <div class="mb-3"><label>Color</label>
            <input type="text" name="color" value="{{ old('color', $equipo->color) }}" class="form-control">
        </div>
        <div class="mb-3"><label>IMEI / Serie</label>
            <input type="text" name="imei" value="{{ old('imei', $equipo->imei) }}" class="form-control">
        </div>
        <div class="mb-3"><label>Condición física</label>
            <input type="text" name="condicion_fisica" value="{{ old('condicion_fisica', $equipo->condicion_fisica) }}" class="form-control">
        </div>
        <div class="mb-3"><label>Estética</label>
            <input type="text" name="estetica" value="{{ old('estetica', $equipo->estetica) }}" class="form-control">
        </div>
        <div class="mb-3"><label>Tipo de bloqueo</label>
            <input type="text" name="tipo_bloqueo" value="{{ old('tipo_bloqueo', $equipo->tipo_bloqueo) }}" class="form-control">
        </div>
        <div class="mb-3"><label>Zona de trabajo</label>
            <input type="text" name="zona_trabajo" value="{{ old('zona_trabajo', $equipo->zona_trabajo) }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
