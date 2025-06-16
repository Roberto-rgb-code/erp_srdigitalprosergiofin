<?php

namespace App\Exports;

use App\Models\DetalleVenta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetalleVentasExport implements FromCollection, WithHeadings
{
    protected $venta_id;

    public function __construct($venta_id)
    {
        $this->venta_id = $venta_id;
    }

    public function collection()
    {
        return DetalleVenta::where('venta_id', $this->venta_id)
            ->get(['id', 'producto_servicio', 'cantidad', 'precio_unitario', 'subtotal']);
    }

    public function headings(): array
    {
        return ['ID', 'Producto/Servicio', 'Cantidad', 'Precio Unitario', 'Subtotal'];
    }
}
