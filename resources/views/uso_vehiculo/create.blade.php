@extends('layouts.app')
@section('content')
    <h2>Registrar Uso - {{ $vehiculo->placa }}</h2>
    <form method="POST" action="{{ route('vehiculos.uso.store', $vehiculo->id) }}">
        @csrf
        <div class="mb-3">
            <label>Empleado responsable</label>
            <select name="empleado_id" class="form-select" required>
                <option value="">Seleccione...</option>
                @foreach($empleados as $e)
                    <option value="{{ $e->id }}">{{ $e->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Fecha salida</label>
            <input type="date" name="fecha_salida" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Hora salida</label>
            <input type="time" name="hora_salida" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Destino</label>
            <input type="text" name="destino" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Motivo</label>
            <input type="text" name="motivo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fecha retorno</label>
            <input type="date" name="fecha_retorno" class="form-control">
        </div>
        <div class="mb-3">
            <label>Hora retorno</label>
            <input type="time" name="hora_retorno" class="form-control">
        </div>
        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('vehiculos.uso.index', $vehiculo->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
