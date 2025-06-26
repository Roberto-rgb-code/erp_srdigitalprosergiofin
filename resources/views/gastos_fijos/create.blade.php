@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Registrar Gasto Fijo</h2>
    <form method="POST" action="{{ route('gastos_fijos.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Proveedor</label>
                <select name="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror">
                    <option value="">Seleccione...</option>
                    @foreach($proveedores as $p)
                        <option value="{{ $p->id }}" @selected(old('proveedor_id') == $p->id)>{{ $p->nombre }}</option>
                    @endforeach
                </select>
                @error('proveedor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Nombre del Gasto <span class="text-danger">*</span></label>
                <input name="nombre_gasto" class="form-control @error('nombre_gasto') is-invalid @enderror" value="{{ old('nombre_gasto') }}" required>
                @error('nombre_gasto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Monto Mensual <span class="text-danger">*</span></label>
                <input name="monto" type="number" step="0.01" class="form-control" value="{{ old('monto') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Fecha de vencimiento</label>
                <input name="fecha_vencimiento" type="date" class="form-control" value="{{ old('fecha_vencimiento') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Categoría</label>
                <input name="categoria" type="text" class="form-control" value="{{ old('categoria') }}">
            </div>
        </div>
        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('gastos_fijos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
