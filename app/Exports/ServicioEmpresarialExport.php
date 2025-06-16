<?php

namespace App\Exports;

use App\Models\ServicioEmpresarial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServicioEmpresarialExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ServicioEmpresarial::with(['cliente', 'poliza'])->get()->map(function($s) {
            return [
                'ID' => $s->id,
                'Cliente' => $s->cliente->nombre ?? '',
                'Póliza' => $s->poliza->nombre ?? '',
                'Estatus' => $s->estatus,
                'Comentarios' => $s->comentarios,
                'Fecha creación' => $s->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Póliza',
            'Estatus',
            'Comentarios',
            'Fecha creación'
        ];
    }
}
