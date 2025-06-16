@extends('layouts.app')
@section('content')
    <h2>Editar Consumo - {{ $vehiculo->placa }}</h2>
    <form method="POST" action="{{ route('vehiculos.consumo.update', [$vehiculo->id, $consumo->id]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Litros</label>
            <input type="number" step="0.01" name="litros" class="form-control" required value="{{ old('litros', $consumo->litros) }}">
        </div>
        <div class="mb-3">
            <label>Monto</label>
            <input type="number" step="0.01" name="monto" class="form-control" required value="{{ old('monto', $consumo->monto) }}">
        </div>
        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required value="{{ old('fecha', $consumo->fecha) }}">
        </div>
        <div class="mb-3">
            <label>Ticket (opcional)</label>
            <input type="text" name="ticket" class="form-control" value="{{ old('ticket', $consumo->ticket) }}">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('vehiculos.consumo.index', $vehiculo->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
