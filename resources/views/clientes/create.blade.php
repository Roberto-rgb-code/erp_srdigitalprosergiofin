{{-- resources/views/clientes/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <h2>Nuevo Cliente</h2>
    <form method="POST" action="{{ route('clientes.store') }}" enctype="multipart/form-data">
        @csrf
        @include('clientes.partials.form')
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
