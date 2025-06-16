<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VentasExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Venta::with('cliente');
        if (!empty($this->filters['cliente_id'])) {
            $query->where('cliente_id', $this->filters['cliente_id']);
        }
        if (!empty($this->filters['estatus'])) {
            $query->where('estatus', $this->filters['estatus']);
        }
        if (!empty($this->filters['tipo_venta'])) {
            $query->where('tipo_venta', $this->filters['tipo_venta']);
        }
        if (!empty($this->filters['fecha_venta'])) {
            $query->where('fecha_venta', $this->filters['fecha_venta']);
        }
        $ventas = $query->orderBy('id', 'desc')->get();

        return $ventas->map(function ($v) {
            return [
                'ID'           => $v->id,
                'Cliente'      => $v->cliente->nombre ?? '',
                'Fecha'        => $v->fecha_venta,
                'Monto Total'  => $v->monto_total,
                'Estatus'      => $v->estatus,
                'Tipo de Venta'=> $v->tipo_venta,
                'Comentarios'  => $v->comentarios,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Cliente', 'Fecha', 'Monto Total', 'Estatus', 'Tipo de Venta', 'Comentarios'];
    }
}
