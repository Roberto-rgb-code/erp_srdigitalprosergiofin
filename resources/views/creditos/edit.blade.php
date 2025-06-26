@extends('layouts.app')
@section('content')
<div class="card mt-4 shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Editar Crédito</h4>
        <a href="{{ route('creditos.show', $credito) }}" class="btn btn-secondary btn-sm">Ver detalle</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('creditos.update', $credito) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Cliente <span class="text-danger">*</span></label>
                <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                    <option value="">Seleccione...</option>
                    @foreach($clientes as $cl)
                        <option value="{{ $cl->id }}" @selected(old('cliente_id', $credito->cliente_id) == $cl->id)>
                            {{ $cl->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Línea de crédito total <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="linea_total" class="form-control @error('linea_total') is-invalid @enderror" required value="{{ old('linea_total', $credito->linea_total) }}">
                @error('linea_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Línea usada</label>
                <input type="number" step="0.01" name="linea_usada" class="form-control @error('linea_usada') is-invalid @enderror" value="{{ old('linea_usada', $credito->linea_usada) }}">
                @error('linea_usada') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Saldo actual</label>
                <input type="number" step="0.01" name="saldo_actual" class="form-control @error('saldo_actual') is-invalid @enderror" value="{{ old('saldo_actual', $credito->saldo_actual) }}">
                @error('saldo_actual') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Estatus del crédito <span class="text-danger">*</span></label>
                <select name="status_credito" class="form-select @error('status_credito') is-invalid @enderror" required>
                    <option value="">Seleccione...</option>
                    <option value="Aprobado" @selected(old('status_credito', $credito->status_credito) == 'Aprobado')>Aprobado</option>
                    <option value="Pendiente" @selected(old('status_credito', $credito->status_credito) == 'Pendiente')>Pendiente</option>
                    <option value="Suspendido" @selected(old('status_credito', $credito->status_credito) == 'Suspendido')>Suspendido</option>
                    <option value="Vencido" @selected(old('status_credito', $credito->status_credito) == 'Vencido')>Vencido</option>
                </select>
                @error('status_credito') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Tiempo de crédito (días)</label>
                <input type="number" name="tiempo_credito" class="form-control @error('tiempo_credito') is-invalid @enderror" value="{{ old('tiempo_credito', $credito->tiempo_credito) }}">
                @error('tiempo_credito') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Semáforo</label>
                <select name="semaforo" class="form-select @error('semaforo') is-invalid @enderror">
                    <option value="">Seleccione...</option>
                    <option value="success" @selected(old('semaforo', $credito->semaforo) == 'success')>Verde</option>
                    <option value="warning" @selected(old('semaforo', $credito->semaforo) == 'warning')>Amarillo</option>
                    <option value="danger" @selected(old('semaforo', $credito->semaforo) == 'danger')>Rojo</option>
                </select>
                @error('semaforo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Especificaciones</label>
                <textarea name="especificaciones" class="form-control @error('especificaciones') is-invalid @enderror">{{ old('especificaciones', $credito->especificaciones) }}</textarea>
                @error('especificaciones') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <a href="{{ route('creditos.show', $credito) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
