<?php

namespace App\Exports;

use App\Models\Vehiculo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehiculosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Vehiculo::with(['responsable', 'cliente'])->get()->map(function($v) {
            return [
                $v->id,
                $v->placa,
                $v->marca,
                $v->modelo,
                $v->año,
                $v->tipo,
                $v->kilometraje,
                $v->responsable->nombre ?? '-',
                $v->cliente->nombre ?? '-',
                $v->status,
                $v->fecha_adquisicion
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Placa', 'Marca', 'Modelo', 'Año', 'Tipo', 'Kilometraje', 'Responsable', 'Cliente', 'Estado', 'Fecha adquisición'];
    }
}
