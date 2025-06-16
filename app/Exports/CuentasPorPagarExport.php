<?php

namespace App\Exports;

use App\Models\CuentaPorPagar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CuentasPorPagarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CuentaPorPagar::with('proveedor')
            ->get()
            ->map(function ($c) {
                return [
                    'Proveedor'      => $c->proveedor->nombre ?? '',
                    'Factura'        => $c->factura,
                    'Monto'          => $c->monto,
                    'Saldo'          => $c->saldo,
                    'Fecha venc.'    => $c->fecha_vencimiento,
                    'Fecha pago'     => $c->fecha_pago,
                    'Estatus'        => $c->estatus,
                    'Comentarios'    => $c->comentarios,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Proveedor',
            'Factura',
            'Monto',
            'Saldo',
            'Fecha vencimiento',
            'Fecha pago',
            'Estatus',
            'Comentarios',
        ];
    }
}
