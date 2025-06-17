<?php

namespace App\Exports;

use App\Models\Cableado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CableadoExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Cableado::with('cliente')->get()->map(function($c){
            return [
                'ID'               => $c->id,
                'Proyecto'         => $c->nombre_proyecto,
                'Cliente'          => $c->cliente->nombre ?? '',
                'Tipo instalación' => $c->tipo_instalacion,
                'Dirección'        => $c->direccion,
                'Inicio'           => $c->fecha_inicio,
                'Fin'              => $c->fecha_fin,
                'Responsable'      => $c->responsable, // ahora solo el campo de texto
                'Estado'           => $c->estatus,
                'Costo estimado'   => $c->costo_estimado,
                'Costo real'       => $c->costo_real,
                'Comentarios'      => $c->comentarios,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Proyecto',
            'Cliente',
            'Tipo instalación',
            'Dirección',
            'Inicio',
            'Fin',
            'Responsable',
            'Estado',
            'Costo estimado',
            'Costo real',
            'Comentarios'
        ];
    }
}
