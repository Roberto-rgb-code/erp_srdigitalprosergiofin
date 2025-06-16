<?php

namespace App\Exports;

use App\Models\Taller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TallerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Taller::with(['cliente','equipo','tecnico'])->get()->map(function($t){
            return [
                'Folio'             => $t->folio,
                'Cliente'           => $t->cliente->nombre ?? '',
                'Tipo de cliente'   => $t->tipo_cliente,
                'Equipo'            => $t->equipo->tipo.' '.$t->equipo->marca.' '.$t->equipo->modelo,
                'IMEI/Serie'        => $t->equipo->imei,
                'Condición física'  => $t->condicion_fisica,
                'Estética'          => $t->estetica,
                'Bloqueo'           => $t->tipo_bloqueo,
                'Zona'              => $t->zona_trabajo,
                'Ingreso'           => $t->fecha_ingreso,
                'Entrega'           => $t->fecha_entrega,
                'Técnico'           => $t->tecnico->nombre ?? '',
                'Problema'          => $t->detalle_problema,
                'Solución'          => $t->solucion,
                'Costo'             => $t->costo_total,
                'Anticipo'          => $t->anticipo,
                'Estatus'           => $t->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Folio','Cliente','Tipo de cliente','Equipo','IMEI/Serie','Condición física',
            'Estética','Bloqueo','Zona','Ingreso','Entrega','Técnico','Problema',
            'Solución','Costo','Anticipo','Estatus'
        ];
    }
}
