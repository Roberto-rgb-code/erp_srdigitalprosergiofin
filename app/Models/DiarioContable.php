<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    // Relación inversa con Venta
    public function venta()
    {
        return $this->belongsTo(\App\Models\Venta::class, 'venta_id');
    }

    // Relación inversa con Producto
    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'producto_id');
    }
}
