@extends('layouts.app')
@section('content')
    <h2>Editar Venta</h2>
    <form method="POST" action="{{ route('ventas.update', $venta) }}">
        @csrf
        @method('PUT')
        @include('ventas.partials.form')
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
