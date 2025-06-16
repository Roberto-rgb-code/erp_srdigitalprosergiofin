@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Nueva Cuenta por Pagar</h2>
    <form action="{{ route('cuentas_por_pagar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Proveedor</label>
            <select name="proveedor_id" class="form-control" required>
                <option value="">Selecciona</option>
                @foreach($proveedores as $p)
                    <option value="{{ $p->id }}" {{ old('proveedor_id') == $p->id ? 'selected' : '' }}>{{ $p->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Egreso relacionado</label>
            <select name="egreso_id" class="form-control">
                <option value="">(Opcional)</option>
                @foreach($egresos as $e)
                    <option value="{{ $e->id }}" {{ old('egreso_id') == $e->id ? 'selected' : '' }}>
                        #{{ $e->id }} - {{ $e->descripcion ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Factura</label>
            <input type="text" name="factura" class="form-control" maxlength="100" value="{{ old('factura') }}">
        </div>

        <div class="mb-3">
            <label>Monto</label>
            <input type="number" name="monto" class="form-control" step="0.01" required value="{{ old('monto') }}">
        </div>

        <div class="mb-3">
            <label>Saldo</label>
            <input type="number" name="saldo" class="form-control" step="0.01" required value="{{ old('saldo') }}">
        </div>

        <div class="mb-3">
            <label>Fecha de vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control" required value="{{ old('fecha_vencimiento') }}">
        </div>

        <div class="mb-3">
            <label>Comprobante (XML, PDF, JPG, PNG)</label>
            <input type="file" name="comprobante" class="form-control">
        </div>

        <div class="mb-3">
            <label>Estatus</label>
            <select name="estatus" class="form-control" required>
                <option value="En tiempo" {{ old('estatus') == 'En tiempo' ? 'selected' : '' }}>En tiempo</option>
                <option value="Próximo a vencer" {{ old('estatus') == 'Próximo a vencer' ? 'selected' : '' }}>Próximo a vencer</option>
                <option value="Vencido" {{ old('estatus') == 'Vencido' ? 'selected' : '' }}>Vencido</option>
                <option value="Pagado" {{ old('estatus') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('cuentas_por_pagar.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
