@extends('layouts.app')
@section('content')
<h2>Registrar Nuevo Equipo</h2>
<form method="POST" action="{{ route('equipos.store') }}">
    @csrf
    <div class="mb-3">
        <label>Tipo</label>
        <input type="text" name="tipo" class="form-control" required value="{{ old('tipo') }}">
    </div>
    <div class="mb-3">
        <label>Marca</label>
        <input type="text" name="marca" class="form-control" value="{{ old('marca') }}">
    </div>
    <div class="mb-3">
        <label>Modelo</label>
        <input type="text" name="modelo" class="form-control" value="{{ old('modelo') }}">
    </div>
    <div class="mb-3">
        <label>Color</label>
        <input type="color" name="color" class="form-control form-control-color" value="{{ old('color','#000000') }}">
        <small>Selecciona color visual</small>
    </div>
    <div class="mb-3">
        <label>IMEI / Serie</label>
        <input type="text" name="imei" class="form-control" value="{{ old('imei') }}">
    </div>
    <div class="mb-3">
        <label>Condición física</label>
        <input type="text" name="condicion_fisica" class="form-control" value="{{ old('condicion_fisica') }}">
    </div>
    <div class="mb-3">
        <label>Estética</label>
        <select name="estetica" class="form-select">
            <option value="">Seleccione...</option>
            <option value="Bueno" @selected(old('estetica') == 'Bueno')>Bueno</option>
            <option value="Regular" @selected(old('estetica') == 'Regular')>Regular</option>
            <option value="Malo" @selected(old('estetica') == 'Malo')>Malo</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Zona de trabajo</label>
        <input type="text" name="zona_trabajo" class="form-control" value="{{ old('zona_trabajo') }}">
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
