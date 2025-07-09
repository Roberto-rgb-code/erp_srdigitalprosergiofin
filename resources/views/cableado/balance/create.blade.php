@extends('layouts.app')

@section('content')

<h2>Nuevo registro de Balance para proyecto: {{ $cableado->nombre_proyecto }}</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('balance.store', $cableado) }}">
    @csrf

    <div class="mb-3">
        <label for="responsable_id" class="form-label">Responsable</label>
        <select name="responsable_id" id="responsable_id" class="form-select" required>
            <option value="">Seleccione...</option>
            @foreach($responsables as $r)
                <option value="{{ $r->id }}" @selected(old('responsable_id') == $r->id)>{{ $r->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="fecha_gasto" class="form-label">Fecha del gasto</label>
        <input type="date" name="fecha_gasto" id="fecha_gasto" class="form-control" value="{{ old('fecha_gasto') }}" required>
    </div>

    <div class="mb-3">
        <label for="tipo_movimiento" class="form-label">Tipo de movimiento</label>
        <select name="tipo_movimiento" id="tipo_movimiento" class="form-select" required>
            <option value="">Seleccione...</option>
            <option value="ingreso" @selected(old('tipo_movimiento') == 'ingreso')>Ingreso</option>
            <option value="egreso" @selected(old('tipo_movimiento') == 'egreso')>Egreso</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="monto" class="form-label">Monto</label>
        <input type="number" name="monto" id="monto" class="form-control" step="0.01" min="0" value="{{ old('monto') }}" required>
    </div>

    <div class="mb-3">
        <label for="facturable" class="form-label">Facturable</label>
        <select name="facturable" id="facturable" class="form-select" required>
            <option value="">Seleccione...</option>
            <option value="1" @selected(old('facturable') == '1')>Sí</option>
            <option value="0" @selected(old('facturable') == '0')>No</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('cableado.show', $cableado) }}" class="btn btn-secondary">Cancelar</a>
</form>

@endsection
