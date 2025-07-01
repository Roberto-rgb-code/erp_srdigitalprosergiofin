<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Trae todos los productos con proveedor relacionado.
     */
    public function collection()
    {
        return Producto::with('proveedor')->get();
    }

    /**
     * Define los encabezados de la hoja.
     */
    public function headings(): array
    {
        return [
            'Folio',
            'Proveedor',
            'Tipo',
            'Producto',
            'SKU',
            'No. Serie',
            'Cantidad',
            'Costo Unitario',
            'Precio Venta',
            'Precio Mayoreo',
            'Costo Total',
        ];
    }

    /**
     * Define el mapeo de cada fila.
     */
    public function map($p): array
    {
        return [
            $p->folio ?? $p->id,
            $p->proveedor ? $p->proveedor->nombre : 'Sin proveedor',
            $p->tipo_producto,
            $p->producto,
            $p->sku,
            $p->numero_serie,
            $p->cantidad,
            $p->costo_unitario,
            $p->precio_venta,
            $p->precio_mayoreo,
            $p->costo_total,
        ];
    }
}
