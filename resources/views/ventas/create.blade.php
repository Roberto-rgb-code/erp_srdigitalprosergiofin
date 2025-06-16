@extends('layouts.app')
@section('content')
    <h2>Nueva Venta</h2>
    <form method="POST" action="{{ route('ventas.store') }}">
        @csrf
        @include('ventas.partials.form')
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
