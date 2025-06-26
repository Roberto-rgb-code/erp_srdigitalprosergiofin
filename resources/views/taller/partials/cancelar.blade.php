<div class="mb-2">
    <strong>Cliente:</strong> {{ $taller->cliente->nombre_completo ?? '-' }}<br>
    <strong>Estado:</strong> {{ $taller->status }}<br>
    <strong>Total:</strong> {{ $taller->costo_total ?? 0 }}<br>
    <strong>Total pagado:</strong> 0 {{-- Pon aquí la suma de pagos si tienes la relación --}}<br>
    <strong>Adeudo:</strong> {{ $taller->costo_total - $taller->anticipo }}<br>
    <strong>Monto:</strong> {{-- Monto a reembolsar o cobrar --}} <br>
    <label>¿Habrá reembolso?</label>
    <select class="form-select mt-2">
        <option>No</option>
        <option>Sí</option>
    </select>
    {{-- Puedes agregar un botón para cancelar/guardar aquí --}}
</div>
