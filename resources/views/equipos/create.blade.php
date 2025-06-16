@extends('layouts.app')
@section('content')
    <h2>Registrar Nuevo Equipo</h2>
    <form method="POST" action="{{ route('equipos.store') }}">
        @csrf
        <div class="mb-3"><label>Tipo</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>
        <div class="mb-3"><label>Marca</label>
            <input type="text" name="marca" class="form-control">
        </div>
        <div class="mb-3"><label>Modelo</label>
            <input type="text" name="modelo" class="form-control">
        </div>
        <div class="mb-3"><label>Color</label>
            <input type="text" name="color" class="form-control">
        </div>
        <div class="mb-3"><label>IMEI / Serie</label>
            <input type="text" name="imei" class="form-control">
        </div>
        <div class="mb-3"><label>Condición física</label>
            <input type="text" name="condicion_fisica" class="form-control">
        </div>
        <div class="mb-3"><label>Estética</label>
            <input type="text" name="estetica" class="form-control">
        </div>
        <div class="mb-3"><label>Tipo de bloqueo</label>
            <input type="text" name="tipo_bloqueo" class="form-control">
        </div>
        <div class="mb-3"><label>Zona de trabajo</label>
            <input type="text" name="zona_trabajo" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
