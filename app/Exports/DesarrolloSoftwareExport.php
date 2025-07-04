<?php

namespace App\Exports;

use App\Models\DesarrolloSoftware;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DesarrolloSoftwareExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DesarrolloSoftware::with(['cliente', 'responsable'])
            ->get()
            ->map(function ($p) {
                return [
                    'nombre'      => $p->nombre,
                    'cliente'     => $p->cliente->nombre ?? '',
                    'tipo'        => $p->tipo_software ?? '',  // Aquí se usa el campo texto libre
                    'responsable' => $p->responsable->nombre ?? '',
                    'estado'      => $p->estado,
                    'inicio'      => $p->fecha_inicio,
                    'entrega'     => $p->fecha_fin,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nombre', 'Cliente', 'Tipo', 'Responsable', 'Estado', 'Inicio', 'Entrega'];
    }
}
