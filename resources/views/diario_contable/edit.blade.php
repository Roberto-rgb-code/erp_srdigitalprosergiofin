@extends('layouts.app')
@section('content')
<div class="container">
    <h2>{{ isset($movimiento) ? 'Editar' : 'Nuevo' }} Movimiento del Diario</h2>
    <form method="POST" action="{{ isset($movimiento) ? route('diario_contable.update', $movimiento) : route('diario_contable.store') }}">
        @csrf
        @if(isset($movimiento)) @method('PUT') @endif
        <div class="mb-2">
            <label>Póliza</label>
            <select name="poliza_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach($polizas as $p)
                <option value="{{ $p->id }}" @selected(old('poliza_id', $movimiento->poliza_id ?? '') == $p->id)>
                    {{ $p->tipo }} ({{ $p->fecha }}) - {{ $p->descripcion }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Cuenta</label>
            <select name="cuenta_contable_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach($cuentas as $c)
                <option value="{{ $c->id }}" @selected(old('cuenta_contable_id', $movimiento->cuenta_contable_id ?? '') == $c->id)>
                    {{ $c->codigo }} - {{ $c->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Cargo</label>
            <input type="number" step="0.01" name="cargo" class="form-control" value="{{ old('cargo', $movimiento->cargo ?? '0.00') }}">
        </div>
        <div class="mb-2">
            <label>Abono</label>
            <input type="number" step="0.01" name="abono" class="form-control" value="{{ old('abono', $movimiento->abono ?? '0.00') }}">
        </div>
        <div class="mb-2">
            <label>Descripción</label>
            <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $movimiento->descripcion ?? '') }}">
        </div>
        <button class="btn btn-success" type="submit">Guardar</button>
        <a href="{{ route('diario_contable.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
