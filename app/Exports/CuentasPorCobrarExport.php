<?php

namespace App\Exports;

use App\Models\CuentaPorCobrar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CuentasPorCobrarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CuentaPorCobrar::with('cliente')
            ->get()
            ->map(function ($cxc) {
                return [
                    'ID' => $cxc->id,
                    'Cliente' => $cxc->cliente->nombre ?? '',
                    'Monto' => $cxc->monto,
                    'Saldo' => $cxc->saldo,
                    'Fecha vencimiento' => $cxc->fecha_vencimiento,
                    'Estatus' => $cxc->estatus,
                    'Comentarios' => $cxc->comentarios,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Cliente', 'Monto', 'Saldo', 'Fecha vencimiento', 'Estatus', 'Comentarios'];
    }
}
