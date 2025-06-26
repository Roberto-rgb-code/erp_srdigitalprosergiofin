@extends('layouts.app')
@section('content')
<div class="card mt-4 shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Detalle de Crédito</h4>
        <a href="{{ route('creditos.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <ul class="nav nav-tabs" id="tabs-credito" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                    Información General
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#docs" type="button" role="tab">
                    Documentos
                </button>
            </li>
        </ul>
        <div class="tab-content pt-3" id="myTabContent">
            <!-- TAB INFO -->
            <div class="tab-pane fade show active" id="info" role="tabpanel">
                <dl class="row">
                    <dt class="col-sm-4">Cliente</dt>
                    <dd class="col-sm-8">{{ $credito->cliente->nombre_completo ?? '-' }}</dd>
                    <dt class="col-sm-4">Línea Total</dt>
                    <dd class="col-sm-8">${{ number_format($credito->linea_total,2) }}</dd>
                    <dt class="col-sm-4">Línea Usada</dt>
                    <dd class="col-sm-8">${{ number_format($credito->linea_usada,2) }}</dd>
                    <dt class="col-sm-4">Línea Libre</dt>
                    <dd class="col-sm-8">${{ number_format($credito->linea_libre,2) }}</dd>
                    <dt class="col-sm-4">Saldo Actual</dt>
                    <dd class="col-sm-8">${{ number_format($credito->saldo_actual,2) }}</dd>
                    <dt class="col-sm-4">Estatus</dt>
                    <dd class="col-sm-8">{{ $credito->status_credito }}</dd>
                    <dt class="col-sm-4">Tiempo Crédito</dt>
                    <dd class="col-sm-8">{{ $credito->tiempo_credito }} días</dd>
                    <dt class="col-sm-4">Semáforo</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-{{ $credito->semaforo ?? 'secondary' }}">
                            {{ ucfirst($credito->semaforo ?? 'N/A') }}
                        </span>
                    </dd>
                    <dt class="col-sm-4">Especificaciones</dt>
                    <dd class="col-sm-8">{{ $credito->especificaciones }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('creditos.edit', $credito) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                </div>
            </div>
            <!-- TAB DOCS -->
            <div class="tab-pane fade" id="docs" role="tabpanel">
                <form method="POST" action="{{ route('documentos_credito.store') }}" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <input type="hidden" name="credito_id" value="{{ $credito->id }}">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label>Tipo de documento</label>
                            <select name="tipo_documento" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <option value="constancia">Constancia situación fiscal</option>
                                <option value="solicitud">Solicitud de crédito</option>
                                <option value="acta">Acta constitutiva</option>
                                <option value="ine">INE representante legal</option>
                                <option value="domicilio">Comprobante de domicilio</option>
                                <option value="pagare">Carta de compromiso/pagaré</option>
                                <option value="referencias">Referencias comerciales</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Archivo</label>
                            <input type="file" name="archivo" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success">Subir documento</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Archivo</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($credito->documentos as $doc)
                        <tr>
                            <td>{{ ucfirst($doc->tipo_documento) }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank">Descargar</a>
                            </td>
                            <td>
                                {{ $doc->fecha_subida 
                                    ? \Carbon\Carbon::parse($doc->fecha_subida)->format('d/m/Y H:i')
                                    : '' 
                                }}
                            </td>
                            <td>
                                <form method="POST" action="{{ route('documentos_credito.destroy', $doc) }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este documento?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No hay documentos subidos.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
