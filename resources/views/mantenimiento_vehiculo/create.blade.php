@extends('layouts.app')
@section('content')
    <h2>Registrar Mantenimiento - {{ $vehiculo->placa }}</h2>
    <form method="POST" action="{{ route('vehiculos.mantenimiento.store', $vehiculo->id) }}">
        @csrf
        <div class="mb-3">
            <label>Tipo de servicio</label>
            <input type="text" name="tipo_servicio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kilometraje</label>
            <input type="number" step="0.01" name="kilometraje" class="form-control">
        </div>
        <div class="mb-3">
            <label>Costo</label>
            <input type="number" step="0.01" name="costo" class="form-control">
        </div>
        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('vehiculos.mantenimiento.index', $vehiculo->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
