@extends('layouts.app')
@section('content')
<h2>Editar Configuración Técnica</h2>
@if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form action="{{ route('configuraciones_clientes.update', $configuraciones_cliente) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2"><label>Cliente:</label>
        <select name="cliente_id" class="form-control">
            @foreach($clientes as $c)
                <option value="{{ $c->id }}" @if($c->id == $configuraciones_cliente->cliente_id) selected @endif>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label>Tipo:</label><input name="tipo" class="form-control" value="{{ $configuraciones_cliente->tipo }}"></div>
    <div class="mb-2"><label>Descripción:</label><input name="descripcion" class="form-control" value="{{ $configuraciones_cliente->descripcion }}"></div>
    <div class="mb-2"><label>Dato:</label><input name="dato" class="form-control" value="{{ $configuraciones_cliente->dato }}"></div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('configuraciones_clientes.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
