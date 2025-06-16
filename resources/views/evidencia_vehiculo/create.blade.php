@extends('layouts.app')
@section('content')
    <h2>Agregar Evidencia - {{ $vehiculo->placa }}</h2>
    <form method="POST" action="{{ route('vehiculos.evidencia.store', $vehiculo->id) }}">
        @csrf
        <div class="mb-3">
            <label>Relacionado a uso (opcional)</label>
            <select name="uso_id" class="form-select">
                <option value="">Ninguno</option>
                @foreach($usos as $u)
                    <option value="{{ $u->id }}">#{{ $u->id }} - {{ $u->fecha_salida }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-select" required>
                <option value="Entrada">Entrada</option>
                <option value="Salida">Salida</option>
                <option value="Daño">Daño</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Archivo (ruta o nombre, integra subida real si gustas)</label>
            <input type="text" name="archivo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('vehiculos.evidencia.index', $vehiculo->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
