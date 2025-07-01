@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Editar Venta</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('ventas.update', $venta->id) }}">
        @csrf
        @method('PUT')
        @include('ventas.partials.form')
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
