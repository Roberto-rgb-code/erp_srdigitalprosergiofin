@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cuentas por Pagar</h2>
    <div class="mb-3">
        <a href="{{ route('cuentas_por_pagar.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nueva factura a pagar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Proveedor</th>
                <th>Folio Factura</th>
                <th>Monto</th>
                <th>Fecha emisión</th>
                <th>Vencimiento</th>
                <th>PDF</th>
                <th>XML</th>
                <th>Comentarios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($cuentas as $cxp)
            <tr>
                <td>{{ $cxp->proveedor->nombre ?? '-' }}</td>
                <td>{{ $cxp->folio_factura }}</td>
                <td>${{ number_format($cxp->monto,2) }}</td>
                <td>{{ $cxp->fecha_emision ? \Carbon\Carbon::parse($cxp->fecha_emision)->format('d/m/Y') : '-' }}</td>
                <td>{{ $cxp->fecha_vencimiento ? \Carbon\Carbon::parse($cxp->fecha_vencimiento)->format('d/m/Y') : '-' }}</td>
                <td>
                    @if($cxp->pdf_sat)
                        <a href="{{ asset('storage/'.$cxp->pdf_sat) }}" target="_blank">PDF</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($cxp->xml_sat)
                        <a href="{{ asset('storage/'.$cxp->xml_sat) }}" target="_blank">XML</a>
                    @else
                        -
                    @endif
                </td>
                <td>{{ Str::limit($cxp->comentarios, 30) }}</td>
                <td>
                    <a href="{{ route('cuentas_por_pagar.edit', $cxp) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('cuentas_por_pagar.destroy', $cxp) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar factura?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No hay facturas registradas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div>
        {{ $cuentas->links() }}
    </div>
</div>
@endsection
