@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nueva Cuenta por Pagar</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cuentas_por_pagar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-2">
            <label>Proveedor</label>
            <input type="text" name="proveedor" class="form-control" value="{{ old('proveedor') }}" required>
        </div>

        <div class="mb-2">
            <label>Folio factura</label>
            <input type="text" name="folio_factura" class="form-control" value="{{ old('folio_factura') }}" required>
        </div>

        <div class="mb-2">
            <label>Fecha de emisión</label>
            <input type="date" name="fecha_emision" class="form-control" value="{{ old('fecha_emision') }}" required>
        </div>

        <div class="mb-2">
            <label>Fecha de vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control" value="{{ old('fecha_vencimiento') }}" required>
        </div>

        <div class="mb-2">
            <label>Monto total</label>
            <input type="number" step="0.01" name="monto_total" class="form-control" value="{{ old('monto_total') }}" required>
        </div>

        <div class="mb-2">
            <label>Saldo pendiente</label>
            <input type="number" step="0.01" name="saldo_pendiente" class="form-control" value="{{ old('saldo_pendiente') }}" required>
        </div>

        <div class="mb-2">
            <label>XML (SAT)</label>
            <input type="file" name="xml" class="form-control" accept=".xml">
        </div>

        <div class="mb-2">
            <label>PDF (SAT)</label>
            <input type="file" name="pdf" class="form-control" accept=".pdf">
        </div>

        <div class="mb-2">
            <label>Estatus</label>
            <select name="estatus" class="form-select" required>
                <option value="Pendiente" @selected(old('estatus') == 'Pendiente')>Pendiente</option>
                <option value="Pagado" @selected(old('estatus') == 'Pagado')>Pagado</option>
                <option value="Vencido" @selected(old('estatus') == 'Vencido')>Vencido</option>
            </select>
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('cuentas_por_pagar.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
