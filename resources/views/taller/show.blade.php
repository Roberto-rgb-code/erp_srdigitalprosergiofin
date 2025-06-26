@extends('layouts.app')
@section('content')
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Detalle de Orden: {{ $taller->folio }}</h4>
        <a href="{{ route('taller.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs" id="tallerTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Información</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cancelar-tab" data-bs-toggle="tab" data-bs-target="#cancelar" type="button" role="tab">Cancelar servicio</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="refacciones-tab" data-bs-toggle="tab" data-bs-target="#refacciones" type="button" role="tab">Agregar refacciones</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="estado-tab" data-bs-toggle="tab" data-bs-target="#estado" type="button" role="tab">Estado del servicio</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="evidencias-tab" data-bs-toggle="tab" data-bs-target="#evidencias" type="button" role="tab">Evidencias</button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content p-3" id="tallerTabContent">
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                @include('taller.partials.info', ['taller' => $taller])
            </div>
            <div class="tab-pane fade" id="cancelar" role="tabpanel" aria-labelledby="cancelar-tab">
                @include('taller.partials.cancelar', ['taller' => $taller])
            </div>
            <div class="tab-pane fade" id="refacciones" role="tabpanel" aria-labelledby="refacciones-tab">
                @include('taller.partials.refacciones', ['taller' => $taller])
            </div>
            <div class="tab-pane fade" id="estado" role="tabpanel" aria-labelledby="estado-tab">
                @include('taller.partials.estado', ['taller' => $taller])
            </div>
            <div class="tab-pane fade" id="evidencias" role="tabpanel" aria-labelledby="evidencias-tab">
                @include('taller.partials.evidencias', ['taller' => $taller])
            </div>
        </div>
    </div>
</div>
@endsection
