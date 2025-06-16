@extends('layouts.app')
@section('content')
    <h2>Editar Mantenimiento - {{ $vehiculo->placa }}</h2>
    <form method="POST" action="{{ route('vehiculos.mantenimiento.update', [$vehiculo->id, $mantenimiento->id]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Tipo de servicio</label>
            <input type="text" name="tipo_servicio" class="form-control" required value="{{ old('tipo_servicio', $mantenimiento->tipo_servicio) }}">
        </div>
        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required value="{{ old('fecha', $mantenimiento->fecha) }}">
        </div>
        <div class="mb-3">
            <label>Kilometraje</label>
            <input type="number" step="0.01" name="kilometraje" class="form-control" value="{{ old('kilometraje', $mantenimiento->kilometraje) }}">
        </div>
        <div class="mb-3">
            <label>Costo</label>
            <input type="number" step="0.01" name="costo" class="form-control" value="{{ old('costo', $mantenimiento->costo) }}">
        </div>
        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control">{{ old('observaciones', $mantenimiento->observaciones) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('vehiculos.mantenimiento.index', $vehiculo->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
