@extends('layouts.app')
@section('content')
<h2>Nuevo movimiento de Caja Chica</h2>
<form method="POST" action="{{ route('caja_chica.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <label>Fecha</label>
        <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->toDateString()) }}" required>
    </div>
    <div class="mb-2">
        <label>Tipo</label>
        <select name="tipo" class="form-select" required>
            <option value="Entrada" @selected(old('tipo')=='Entrada')>Entrada</option>
            <option value="Salida" @selected(old('tipo')=='Salida')>Salida</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Monto</label>
        <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto') }}" required>
    </div>
    <div class="mb-2">
        <label>Responsable</label>
        <select name="responsable_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            @foreach($responsables as $r)
            <option value="{{ $r->id }}" @selected(old('responsable_id') == $r->id)>
                {{ $r->nombre }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Comprobante</label>
        <input type="file" name="comprobante" class="form-control">
    </div>
    <div class="mb-2">
        <label>Comentarios</label>
        <textarea name="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('caja_chica.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
