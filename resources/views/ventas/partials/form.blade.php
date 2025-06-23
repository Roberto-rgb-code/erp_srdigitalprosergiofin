@php
    $estatusOpciones = ['Pendiente','Pagado','Cancelado'];
    $tipoVentaOpciones = [
        'Efectivo','Transferencia','Tarjeta de crédito',
        'Tarjeta de débito','Línea de crédito','Mixto'
    ];
    $clientes = $clientes ?? \App\Models\Cliente::with('datoFiscal')->get();
    $venta = $venta ?? null;
@endphp

<div class="mb-3">
    <label>Cliente *</label>
    <select name="cliente_id" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach($clientes as $c)
            <option value="{{ $c->id }}" @selected(old('cliente_id', $venta->cliente_id ?? '') == $c->id)>
                {{ $c->nombre_completo }}
            </option>
        @endforeach
    </select>
</div>

{{-- Mostrar datos fiscales del cliente seleccionado (dinámico con JS) --}}
<div class="mb-3" id="datos-fiscales-box">
    {{-- Aquí se rellena con JS si el cliente cambia --}}
    @if(isset($venta) && $venta->cliente && $venta->cliente->datoFiscal)
        <div class="alert alert-info">
            <strong>RFC:</strong> {{ $venta->cliente->datoFiscal->rfc }}<br>
            <strong>Nombre Fiscal:</strong> {{ $venta->cliente->datoFiscal->nombre_fiscal }}<br>
            <strong>Dirección Fiscal:</strong> {{ $venta->cliente->datoFiscal->direccion_fiscal }}<br>
        </div>
    @endif
</div>

<div class="mb-3">
    <label>Fecha de Venta *</label>
    <input type="date" name="fecha_venta" value="{{ old('fecha_venta', $venta->fecha_venta ?? '') }}" class="form-control" required>
</div>

{{-- SECCIÓN DE PRODUCTOS --}}
<div class="mb-3">
    <label>Productos</label>
    <table class="table table-bordered" id="productos-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>No. Serie</th>
                <th>Producto (libre)</th>
                <th>Precio Costo</th>
                <th>Precio Venta</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                $productosViejos = old('productos', isset($venta) ? $venta->detalles->toArray() : []);
            @endphp
            @foreach($productosViejos as $i => $detalle)
                <tr>
                    <td>
                        <input type="text" name="productos[{{ $i }}][sku]" class="form-control" value="{{ $detalle['sku'] ?? '' }}">
                    </td>
                    <td>
                        <input type="text" name="productos[{{ $i }}][no_serie]" class="form-control" value="{{ $detalle['no_serie'] ?? '' }}">
                    </td>
                    <td>
                        <input type="text" name="productos[{{ $i }}][nombre_producto]" class="form-control" required value="{{ $detalle['nombre_producto'] ?? $detalle['producto']['nombre'] ?? '' }}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="productos[{{ $i }}][precio_costo]" class="form-control" value="{{ $detalle['precio_costo'] ?? 0 }}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="productos[{{ $i }}][precio_venta]" class="form-control" required value="{{ $detalle['precio_venta'] ?? $detalle['precio_unitario'] ?? $detalle['precio'] ?? 0 }}">
                    </td>
                    <td>
                        <input type="number" name="productos[{{ $i }}][cantidad]" class="form-control" min="1" required value="{{ $detalle['cantidad'] ?? 1 }}">
                    </td>
                    <td class="subtotal">
                        {{ number_format(($detalle['cantidad'] ?? 1) * ($detalle['precio_venta'] ?? $detalle['precio_unitario'] ?? 0), 2) }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-product">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button type="button" id="add-product" class="btn btn-primary btn-sm">Agregar producto</button>
</div>

<div class="mb-3">
    <label>Monto Total *</label>
    <input type="number" step="0.01" name="monto_total" value="{{ old('monto_total', $venta->monto_total ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label>Método de Pago</label>
    <select name="tipo_venta" class="form-select">
        <option value="">Seleccione...</option>
        @foreach($tipoVentaOpciones as $op)
            <option value="{{ $op }}" @selected(old('tipo_venta', $venta->tipo_venta ?? '') == $op)>{{ $op }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Estatus</label>
    <select name="estatus" class="form-select">
        <option value="">Seleccione...</option>
        @foreach($estatusOpciones as $op)
            <option value="{{ $op }}" @selected(old('estatus', $venta->estatus ?? '') == $op)>{{ $op }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Comentarios</label>
    <textarea name="comentarios" class="form-control">{{ old('comentarios', $venta->comentarios ?? '') }}</textarea>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let i = $('#productos-table tbody tr').length || 0;

    $('#add-product').click(function() {
        let tr = `<tr>
            <td><input type="text" name="productos[${i}][sku]" class="form-control"></td>
            <td><input type="text" name="productos[${i}][no_serie]" class="form-control"></td>
            <td><input type="text" name="productos[${i}][nombre_producto]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="productos[${i}][precio_costo]" class="form-control" value="0"></td>
            <td><input type="number" step="0.01" name="productos[${i}][precio_venta]" class="form-control" value="0" required></td>
            <td><input type="number" name="productos[${i}][cantidad]" class="form-control" min="1" value="1" required></td>
            <td class="subtotal">0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-product">Eliminar</button></td>
        </tr>`;
        $('#productos-table tbody').append(tr);
        i++;
    });

    $('#productos-table').on('click', '.remove-product', function() {
        $(this).closest('tr').remove();
        actualizarTotal();
    });

    $('#productos-table').on('input change', 'input', function() {
        let tr = $(this).closest('tr');
        let cantidad = parseFloat(tr.find('input[name$="[cantidad]"]').val()) || 0;
        let precio = parseFloat(tr.find('input[name$="[precio_venta]"]').val()) || 0;
        let subtotal = cantidad * precio;
        tr.find('.subtotal').text(subtotal.toFixed(2));
        actualizarTotal();
    });

    function actualizarTotal() {
        let total = 0;
        $('#productos-table tbody tr').each(function() {
            let cantidad = parseFloat($(this).find('input[name$="[cantidad]"]').val()) || 0;
            let precio = parseFloat($(this).find('input[name$="[precio_venta]"]').val()) || 0;
            total += cantidad * precio;
        });
        $('input[name="monto_total"]').val(total.toFixed(2));
    }

    // Dinámico: mostrar datos fiscales del cliente seleccionado
    $('select[name="cliente_id"]').change(function() {
        let clienteId = $(this).val();
        $('#datos-fiscales-box').html('');
        if(clienteId) {
            $.get('/api/clientes/' + clienteId + '/datos-fiscales', function(data) {
                if(data && data.rfc){
                    $('#datos-fiscales-box').html(`
                        <div class="alert alert-info">
                            <strong>RFC:</strong> ${data.rfc}<br>
                            <strong>Nombre Fiscal:</strong> ${data.nombre_fiscal}<br>
                            <strong>Dirección Fiscal:</strong> ${data.direccion_fiscal}<br>
                        </div>
                    `);
                }
            });
        }
    });

    // Inicializa totales al cargar
    actualizarTotal();
});
</script>
@endpush
