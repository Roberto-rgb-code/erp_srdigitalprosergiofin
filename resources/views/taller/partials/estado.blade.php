<h5>Estado del Servicio</h5>
<form method="POST" action="{{ route('taller.cambiarEstado', $taller->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-2 align-items-end">
        <div class="col-md-6">
            <label>Estado actual:</label>
            <select name="status" class="form-select mb-2">
                @foreach([
                    'Reparación','Reparado','No quedo','Laboratorio','Entregado no quedo',
                    'Pendiente pago','Diagnosticado','Espera de Refacción','Testear',
                    'Falla avanzada','No autorizado','Esperando autorización',
                    'Espera de refacciones','En garantía'
                ] as $estatus)
                    <option value="{{ $estatus }}" @selected($taller->status == $estatus)>{{ $estatus }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Actualizar estado</button>
        </div>
    </div>
</form>
@if(session('status_updated'))
    <div class="alert alert-success mt-2">{{ session('status_updated') }}</div>
@endif
