@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Nueva Factura a Pagar</h2>
    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cuentas_por_pagar.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Proveedor <span class="text-danger">*</span></label>
                <select name="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
                    <option value="">Seleccione...</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" @selected(old('proveedor_id') == $proveedor->id)>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('proveedor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label>Folio Factura <span class="text-danger">*</span></label>
                <input type="text" name="folio_factura" value="{{ old('folio_factura') }}" class="form-control @error('folio_factura') is-invalid @enderror" required>
                @error('folio_factura') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Monto <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" class="form-control @error('monto') is-invalid @enderror" required>
                @error('monto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label>Fecha de emisión <span class="text-danger">*</span></label>
                <input type="date" name="fecha_emision" value="{{ old('fecha_emision') }}" class="form-control @error('fecha_emision') is-invalid @enderror" required>
                @error('fecha_emision') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label>Fecha de vencimiento <span class="text-danger">*</span></label>
                <input type="date" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" class="form-control @error('fecha_vencimiento') is-invalid @enderror" required>
                @error('fecha_vencimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>XML SAT</label>
                <input type="file" name="xml_sat" class="form-control @error('xml_sat') is-invalid @enderror" accept=".xml">
                @error('xml_sat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label>PDF SAT</label>
                <input type="file" name="pdf_sat" class="form-control @error('pdf_sat') is-invalid @enderror" accept=".pdf">
                @error('pdf_sat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control @error('comentarios') is-invalid @enderror">{{ old('comentarios') }}</textarea>
            @error('comentarios') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('cuentas_por_pagar.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
