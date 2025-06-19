@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cuentas por Pagar</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FILTROS --}}
    <form class="row row-cols-lg-auto g-2 align-items-center mb-4" method="GET">
        <div class="col">
            <select name="proveedor_id" class="form-select">
                <option value="">Todos los proveedores</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id }}" {{ request('proveedor_id') == $prov->id ? 'selected' : '' }}>
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select name="estatus" class="form-select">
                <option value="">Todos los estatus</option>
                <option value="En tiempo" {{ request('estatus') == 'En tiempo' ? 'selected' : '' }}>En tiempo</option>
                <option value="Próximo a vencer" {{ request('estatus') == 'Próximo a vencer' ? 'selected' : '' }}>Próximo a vencer</option>
                <option value="Vencido" {{ request('estatus') == 'Vencido' ? 'selected' : '' }}>Vencido</option>
                <option value="Pagado" {{ request('estatus') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>
        <div class="col">
            <button class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('cuentas_por_pagar.export.excel') }}" class="btn btn-success">Exportar Excel</a>
        <a href="{{ route('cuentas_por_pagar.export.pdf') }}" class="btn btn-danger">Exportar PDF</a>
    </div>

    <div>
        <canvas id="graficoCuentasPorPagar" height="100"></canvas>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>Factura</th>
                    <th>Emisión</th>
                    <th>Vencimiento</th>
                    <th>Monto</th>
                    <th>Saldo</th>
                    <th>Estatus</th>
                    <th>XML</th>
                    <th>PDF</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($cuentas as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->proveedor->nombre ?? '-' }}</td>
                    <td>{{ $c->folio_factura }}</td>
                    <td>{{ $c->fecha_emision }}</td>
                    <td>{{ $c->fecha_vencimiento }}</td>
                    <td>${{ number_format($c->monto_total, 2) }}</td>
                    <td>${{ number_format($c->saldo_pendiente, 2) }}</td>
                    <td>{{ $c->estatus }}</td>
                    <td>
                        @if($c->xml)
                        <a href="{{ Storage::url($c->xml) }}" target="_blank">Ver XML</a>
                        @endif
                    </td>
                    <td>
                        @if($c->pdf)
                        <a href="{{ Storage::url($c->pdf) }}" target="_blank">Ver PDF</a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cuentas_por_pagar.show', $c) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('cuentas_por_pagar.edit', $c) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('cuentas_por_pagar.destroy', $c) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $cuentas->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route('api.graficos.cuentas_por_pagar') }}')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(x => x.proveedor);
            const values = data.map(x => x.total);

            new Chart(document.getElementById('graficoCuentasPorPagar'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Saldo pendiente',
                        data: values,
                        borderWidth: 1
                    }]
                }
            });
        });
});
</script>
@endsection
