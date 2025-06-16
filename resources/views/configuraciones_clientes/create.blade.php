@extends('layouts.app')
@section('content')
<h2>Nueva Configuración Técnica</h2>
@if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form action="{{ route('configuraciones_clientes.store') }}" method="POST">
    @csrf
    <div class="mb-2"><label>Cliente:</label>
        <select name="cliente_id" class="form-control">
            @foreach($clientes as $c)
                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Tipo:</label><input name="tipo" class="form-control"></div>
    <div class="mb-2"><label>Descripción:</label><input name="descripcion" class="form-control"></div>
    <div class="mb-2"><label>Dato:</label><input name="dato" class="form-control"></div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('configuraciones_clientes.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
