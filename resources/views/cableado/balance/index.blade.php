@extends('layouts.app')
@section('content')
<h2>Balance de Cableado Estructurado</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="responsable_id" class="form-select">
            <option value="">Responsable</option>
            @foreach($responsables as $r)
                <option value="{{ $r->id }}" @selected(request('responsable_id') == $r->id)>{{ $r->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="tipo_movimiento" class="form-select">
            <option value="">Tipo Movimiento</option>
            <option value="ingreso" @selected(request('tipo_movimiento') == 'ingreso')>Ingreso</option>
            <option value="egreso" @selected(request('tipo_movimiento') == 'egreso')>Egreso</option>
        </select>
    </div>
    <div class="col-md-3">
        <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
    </div>
    <div class="col-md-3">
        <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
    </div>
    <div class="col-md-12 mt-2">
        <button class="btn btn-primary">Filtrar</button>
        <a href="{{ route('balance_cableado.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        <a href="{{ route('balance_cableado.create') }}" class="btn btn-success float-end">Nuevo registro</a>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Responsable</th>
            <th>Fecha del gasto</th>
            <th>Tipo Movimiento</th>
            <th>Monto</th>
            <th>Facturable</th>
        </tr>
    </thead>
    <tbody>
        @forelse($balances as $b)
            <tr>
                <td>{{ $b->responsable->nombre ?? '-' }}</td>
                <td>{{ $b->fecha_gasto }}</td>
                <td>{{ ucfirst($b->tipo_movimiento) }}</td>
                <td>${{ number_format($b->monto, 2) }}</td>
                <td>{{ $b->facturable ? 'Sí' : 'No' }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No hay registros.</td></tr>
        @endforelse
    </tbody>
</table>

<div>{{ $balances->links() }}</div>
@endsection
