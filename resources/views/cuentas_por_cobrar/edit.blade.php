@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Cuenta por Cobrar</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cuentas_por_cobrar.update', $cuentas_por_cobrar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" @selected(old('cliente_id', $cuentas_por_cobrar->cliente_id) == $c->id)>
                        {{ $c->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="venta_id" class="form-label">Venta (opcional)</label>
            <select name="venta_id" id="venta_id" class="form-select">
                <option value="">-- Selecciona --</option>
                @foreach($ventas as $v)
                    <option value="{{ $v->id }}" @selected(old('venta_id', $cuentas_por_cobrar->venta_id) == $v->id)>
                        {{ $v->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="folio_factura" class="form-label">Folio de Factura</label>
            <input type="text" name="folio_factura" id="folio_factura" class="form-control" required
                value="{{ old('folio_factura', $cuentas_por_cobrar->folio_factura) }}">
        </div>

        <div class="mb-3">
            <label for="fecha_emision" class="form-label">Fecha de Emisión</label>
            <input type="date" name="fecha_emision" id="fecha_emision" class="form-control" required
                value="{{ old('fecha_emision', $cuentas_por_cobrar->fecha_emision ? \Carbon\Carbon::parse($cuentas_por_cobrar->fecha_emision)->format('Y-m-d') : '') }}">
        </div>

        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" required
                value="{{ old('fecha_vencimiento', $cuentas_por_cobrar->fecha_vencimiento ? \Carbon\Carbon::parse($cuentas_por_cobrar->fecha_vencimiento)->format('Y-m-d') : '') }}">
        </div>

        <div class="mb-3">
            <label for="monto_total" class="form-label">Monto Total</label>
            <input type="number" step="0.01" name="monto_total" id="monto_total" class="form-control" required
                value="{{ old('monto_total', $cuentas_por_cobrar->monto_total) }}">
        </div>

        <div class="mb-3">
            <label for="saldo_pendiente" class="form-label">Saldo Pendiente</label>
            <input type="number" step="0.01" name="saldo_pendiente" id="saldo_pendiente" class="form-control" required
                value="{{ old('saldo_pendiente', $cuentas_por_cobrar->saldo_pendiente) }}">
        </div>

        <div class="mb-3">
            <label for="documento" class="form-label">Documento (PDF/JPG/PNG, máx 2MB)</label>
            @if($cuentas_por_cobrar->documento)
                <div class="mb-2">
                    <a href="{{ asset('storage/' . $cuentas_por_cobrar->documento) }}" target="_blank">
                        Ver documento actual
                    </a>
                </div>
            @endif
            <input type="file" name="documento" id="documento" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('cuentas_por_cobrar.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
