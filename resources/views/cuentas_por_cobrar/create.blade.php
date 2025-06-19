@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Cuenta por Cobrar</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cuentas_por_cobrar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">-- Selecciona cliente --</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ old('cliente_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="folio_factura" class="form-label">Folio Factura</label>
            <input type="text" name="folio_factura" class="form-control" value="{{ old('folio_factura') }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha_emision" class="form-label">Fecha de Emisión</label>
            <input type="date" name="fecha_emision" class="form-control" value="{{ old('fecha_emision') }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control" value="{{ old('fecha_vencimiento') }}" required>
        </div>

        <div class="mb-3">
            <label for="monto_total" class="form-label">Monto Total</label>
            <input type="number" name="monto_total" step="0.01" class="form-control" value="{{ old('monto_total') }}" required>
        </div>

        <div class="mb-3">
            <label for="saldo_pendiente" class="form-label">Saldo Pendiente</label>
            <input type="number" name="saldo_pendiente" step="0.01" class="form-control" value="{{ old('saldo_pendiente') }}" required>
        </div>

        <div class="mb-3">
            <label for="documento" class="form-label">Documento (opcional)</label>
            <input type="file" name="documento" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('cuentas_por_cobrar.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
