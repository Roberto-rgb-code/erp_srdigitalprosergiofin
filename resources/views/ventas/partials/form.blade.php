@php
    $estatusOpciones = ['Pendiente','Pagado','Cancelado'];
    $tipoVentaOpciones = [
        'Efectivo','Transferencia','Tarjeta de crédito',
        'Tarjeta de débito','Línea de crédito','Mixto'
    ];
    $productosSeleccionados = [];
    if(isset($venta) && $venta->productos) {
        foreach($venta->productos as $p) {
            $productosSeleccionados[$p->id] = [
                'cantidad' => $p->pivot->cantidad,
                'precio_unitario' => $p->pivot->precio_unitario,
                'stock_unit_ids' => $p->pivot->stock_unit_ids ? json_decode($p->pivot->stock_unit_ids, true) : [],
                'stock_unit_numeros' => [] // se llena en JS
            ];
        }
    }
@endphp

<div class="mb-3">
    <label>Cliente *</label>
    <select name="cliente_id" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach($clientes as $c)
            <option value="{{ $c->id }}"
                @selected(old('cliente_id', $venta->cliente_id ?? '') == $c->id)>
                {{ $c->nombre_completo }}
            </option>
        @endforeach
    </select>
</div>

{{-- Datos fiscales dinámicos --}}
<div class="mb-3" id="datos-fiscales-box">
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

{{-- Selector dinámico de productos --}}
<h5 class="mt-4 mb-2">Agregar productos a la venta</h5>
<div class="card p-3 mb-3 shadow-sm border-0">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label mb-1">Producto</label>
            <select id="select-producto" class="form-select">
                <option value="">Seleccione producto...</option>
                @foreach($productos as $prod)
                    <option value="{{ $prod->id }}"
                        data-precio="{{ $prod->precio_venta }}"
                        data-nombre="{{ $prod->producto }}"
                        data-sku="{{ $prod->sku }}">
                        {{ $prod->producto }} ({{ $prod->sku }}) - Stock: {{ $prod->cantidad }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label mb-1">Precio</label>
            <input type="number" min="0" step="0.01" id="input-precio" class="form-control" disabled>
        </div>
        <div class="col-md-4">
            <label class="form-label mb-1">Números de Serie</label>
            <select id="select-numero-serie" class="form-select" multiple disabled></select>
        </div>
        <div class="col-md-2 d-grid">
            <button type="button" id="btn-agregar-producto" class="btn btn-success" disabled>
                <i class="bi bi-cart-plus"></i> Agregar producto
            </button>
        </div>
    </div>
</div>

<div class="table-responsive mb-3">
    <table class="table table-bordered align-middle" id="tabla-productos-venta">
        <thead class="table-light">
            <tr>
                <th>Producto</th>
                <th>SKU</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Números de Serie</th>
                <th>Total</th>
                <th>Quitar</th>
            </tr>
        </thead>
        <tbody>
            {{-- JS agregará filas dinámicamente --}}
        </tbody>
    </table>
</div>
<div id="productos-campos"></div>

<div class="mb-3">
    <label>Monto Total *</label>
    <input type="number" step="0.01" name="monto_total" value="{{ old('monto_total', $venta->monto_total ?? '') }}" class="form-control" required id="input-monto-total">
    <small class="text-secondary">Se calcula automáticamente según los productos seleccionados.</small>
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
let productosVenta = {!! json_encode($productosSeleccionados) !!};
const productosDatos = @json($productosJson);

// Al seleccionar producto, muestra unidades disponibles (no AJAX, puro JS)
$('#select-producto').change(function() {
    const pid = $(this).val();
    $('#select-numero-serie').html('').prop('disabled', true);
    $('#btn-agregar-producto').prop('disabled', true);

    if(pid && productosDatos[pid]) {
        const unidades = productosDatos[pid].unidades || [];
        if (unidades.length > 0) {
            $('#select-numero-serie').html(
                unidades.map(u =>
                    `<option value="${u.id}">${u.numero_serie}</option>`
                ).join('')
            ).prop('disabled', false);
        } else {
            $('#select-numero-serie').html('<option value="">Sin stock</option>');
        }

        $('#input-precio').val(productosDatos[pid].precio).prop('disabled', false);
    } else {
        $('#input-precio').val('').prop('disabled', true);
        $('#select-numero-serie').html('').prop('disabled', true);
    }
});

// Habilita botón solo si hay series seleccionadas
$('#select-numero-serie').change(function() {
    const selected = $(this).val() || [];
    $('#btn-agregar-producto').prop('disabled', selected.length === 0);
});

// Agrega producto con series seleccionadas
$('#btn-agregar-producto').click(function() {
    const pid = $('#select-producto').val();
    if(!pid) return;
    const precio = parseFloat($('#input-precio').val());
    const stockUnitIds = $('#select-numero-serie').val() || [];
    const stockUnitNumeros = $('#select-numero-serie option:selected').map(function(){ return $(this).text(); }).get();

    if(stockUnitIds.length === 0) return;

    productosVenta[pid] = {
        cantidad: stockUnitIds.length,
        precio_unitario: precio,
        stock_unit_ids: stockUnitIds,
        stock_unit_numeros: stockUnitNumeros
    };

    actualizarTablaProductos();
    $('#select-producto').val('');
    $('#input-precio').val('').prop('disabled', true);
    $('#select-numero-serie').html('').prop('disabled', true);
    $('#btn-agregar-producto').prop('disabled', true);
});

// Renderiza tabla productos
function actualizarTablaProductos() {
    const $tbody = $('#tabla-productos-venta tbody');
    $tbody.html('');
    let montoTotal = 0;
    $('#productos-campos').html('');
    Object.entries(productosVenta).forEach(([pid, obj]) => {
        if(obj.cantidad > 0){
            const data = productosDatos[pid];
            const total = obj.precio_unitario * obj.cantidad;
            montoTotal += total;
            let numerosSerie = (obj.stock_unit_numeros || []).map(n => `<span class="badge bg-info text-dark">${n}</span>`).join(' ');

            $tbody.append(`
                <tr>
                    <td>${data.nombre}</td>
                    <td>${data.sku}</td>
                    <td>$${parseFloat(obj.precio_unitario).toFixed(2)}</td>
                    <td>${obj.cantidad}</td>
                    <td>${numerosSerie}</td>
                    <td>$${total.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProductoVenta(${pid})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

            // Campos ocultos para enviar en el form
            $('#productos-campos').append(`
                <input type="hidden" name="productos[${pid}][cantidad]" value="${obj.cantidad}">
                <input type="hidden" name="productos[${pid}][precio_unitario]" value="${obj.precio_unitario}">
                <input type="hidden" name="productos[${pid}][stock_unit_ids]" value='${JSON.stringify(obj.stock_unit_ids || [])}'>
            `);
        }
    });
    $('#input-monto-total').val(montoTotal.toFixed(2));
}

function eliminarProductoVenta(id) {
    delete productosVenta[id];
    actualizarTablaProductos();
}

$(document).ready(function(){
    // Si es edit, llena los números de serie por cada producto seleccionado
    Object.entries(productosVenta).forEach(([pid, obj]) => {
        if (obj.stock_unit_ids && obj.stock_unit_ids.length) {
            if(productosDatos[pid] && productosDatos[pid].unidades){
                // Busca los números de serie a partir de los ids guardados
                let serieNumeros = productosDatos[pid].unidades.filter(u => obj.stock_unit_ids.includes(u.id.toString())).map(u => u.numero_serie);
                productosVenta[pid].stock_unit_numeros = serieNumeros;
            }
        }
    });
    actualizarTablaProductos();

    // Datos fiscales dinámicos
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
});
</script>
@endpush
