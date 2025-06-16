@extends('layouts.app')
@section('content')
    <h2>Editar Uso - {{ $vehiculo->placa }}</h2>
    <form method="POST" action="{{ route('vehiculos.uso.update', [$vehiculo->id, $uso->id]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Empleado responsable</label>
            <select name="empleado_id" class="form-select" required>
                <option value="">Seleccione...</option>
                @foreach($empleados as $e)
                    <option value="{{ $e->id }}" @selected(old('empleado_id', $uso->empleado_id)==$e->id)>{{ $e->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Fecha salida</label>
            <input type="date" name="fecha_salida" class="form-control" required value="{{ old('fecha_salida', $uso->fecha_salida) }}">
        </div>
        <div class="mb-3">
            <label>Hora salida</label>
            <input type="time" name="hora_salida" class="form-control" required value="{{ old('hora_salida', $uso->hora_salida) }}">
        </div>
        <div class="mb-3">
            <label>Destino</label>
            <input type="text" name="destino" class="form-control" required value="{{ old('destino', $uso->destino) }}">
        </div>
        <div class="mb-3">
            <label>Motivo</label>
            <input type="text" name="motivo" class="form-control" required value="{{ old('motivo', $uso->motivo) }}">
        </div>
        <div class="mb-3">
            <label>Fecha retorno</label>
            <input type="date" name="fecha_retorno" class="form-control" value="{{ old('fecha_retorno', $uso->fecha_retorno) }}">
        </div>
        <div class="mb-3">
            <label>Hora retorno</label>
            <input type="time" name="hora_retorno" class="form-control" value="{{ old('hora_retorno', $uso->hora_retorno) }}">
        </div>
        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control">{{ old('observaciones', $uso->observaciones) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('vehiculos.uso.index', $vehiculo->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
