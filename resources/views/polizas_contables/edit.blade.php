@extends('layouts.app')
@section('content')
<div class="container">
    <h2>{{ isset($poliza) ? 'Editar' : 'Nueva' }} Póliza Contable</h2>
    <form method="POST" action="{{ isset($poliza) ? route('polizas_contables.update', $poliza) : route('polizas_contables.store') }}">
        @csrf
        @if(isset($poliza)) @method('PUT') @endif
        <div class="mb-2">
            <label>Tipo</label>
            <select name="tipo" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach(['Ingreso','Egreso','Diario'] as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo', $poliza->tipo ?? '') == $tipo)>{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $poliza->fecha ?? '') }}" required>
        </div>
        <div class="mb-2">
            <label>Descripción</label>
            <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $poliza->descripcion ?? '') }}">
        </div>
        <button class="btn btn-success" type="submit">Guardar</button>
        <a href="{{ route('polizas_contables.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
