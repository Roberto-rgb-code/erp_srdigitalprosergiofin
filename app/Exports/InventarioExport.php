<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventarioExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Producto::query();

        if (!empty($this->filters['producto'])) {
            $query->where('producto', 'ILIKE', "%{$this->filters['producto']}%")
                  ->orWhere('sku', 'ILIKE', "%{$this->filters['producto']}%");
        }
        if (!empty($this->filters['proveedor'])) {
            $query->where('proveedor', $this->filters['proveedor']);
        }
        if (!empty($this->filters['tipo_producto'])) {
            $query->where('tipo_producto', $this->filters['tipo_producto']);
        }

        $productos = $query->orderBy('id', 'desc')->get();

        return $productos->map(function ($p) {
            return [
                'Folio Compra'       => $p->folio_compra,
                'Proveedor'          => $p->proveedor,
                'Tipo de Producto'   => $p->tipo_producto,
                'Producto'           => $p->producto,
                'SKU'                => $p->sku,
                'No. Serie'          => $p->numero_serie,
                'Cantidad'           => $p->cantidad,
                'Costo Unitario'     => $p->costo_unitario,
                'Precio Venta'       => $p->precio_venta,
                'Precio Mayoreo'     => $p->precio_mayoreo,
                'Costo Total Neto'   => $p->costo_total_neto,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Folio Compra',
            'Proveedor',
            'Tipo de Producto',
            'Producto',
            'SKU',
            'No. Serie',
            'Cantidad',
            'Costo Unitario',
            'Precio Venta',
            'Precio Mayoreo',
            'Costo Total Neto'
        ];
    }
}
