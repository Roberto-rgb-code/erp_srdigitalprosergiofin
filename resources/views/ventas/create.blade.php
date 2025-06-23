@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Nueva Venta</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('ventas.store') }}">
        @csrf
        @include('ventas.partials.form')
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
