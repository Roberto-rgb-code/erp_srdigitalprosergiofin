@extends('layouts.app')
@section('content')
<h2>Editar movimiento de Caja Chica</h2>
<form method="POST" action="{{ route('caja_chica.update', $caja_chica) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Fecha</label>
        <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $caja_chica->fecha) }}" required>
    </div>
    <div class="mb-2">
        <label>Tipo</label>
        <select name="tipo" class="form-select" required>
            <option value="Entrada" @selected(old('tipo', $caja_chica->tipo)=='Entrada')>Entrada</option>
            <option value="Salida" @selected(old('tipo', $caja_chica->tipo)=='Salida')>Salida</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Monto</label>
        <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto', $caja_chica->monto) }}" required>
    </div>
    <div class="mb-2">
        <label>Responsable</label>
        <select name="responsable_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            @foreach($responsables as $r)
            <option value="{{ $r->id }}" @selected(old('responsable_id', $caja_chica->responsable_id) == $r->id)>
                {{ $r->nombre }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-2">
        <label>Comprobante (Dejar vacío para no cambiar)</label>
        <input type="file" name="comprobante" class="form-control">
        @if($caja_chica->comprobante)
            <br>
            <a href="{{ asset('storage/comprobantes/'.$caja_chica->comprobante) }}" target="_blank">Comprobante actual</a>
        @endif
    </div>
    <div class="mb-2">
        <label>Comentarios</label>
        <textarea name="comentarios" class="form-control">{{ old('comentarios', $caja_chica->comentarios) }}</textarea>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('caja_chica.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
