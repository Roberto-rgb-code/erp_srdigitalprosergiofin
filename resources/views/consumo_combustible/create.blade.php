@extends('layouts.app')
@section('content')
    <h2>Registrar Consumo - {{ $vehiculo->placa }}</h2>
    <form method="POST" action="{{ route('vehiculos.consumo.store', $vehiculo->id) }}">
        @csrf
        <div class="mb-3">
            <label>Litros</label>
            <input type="number" step="0.01" name="litros" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Monto</label>
            <input type="number" step="0.01" name="monto" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ticket (opcional)</label>
            <input type="text" name="ticket" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('vehiculos.consumo.index', $vehiculo->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
