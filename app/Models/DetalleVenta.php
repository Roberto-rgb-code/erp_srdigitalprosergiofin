<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'venta_id',
        'producto_id',
        'producto_nombre', // si usas producto libre/captura manual
        'cantidad',
        'precio_unitario',
        'subtotal',
        // agrega más campos si tienes
    ];

    public function producto()
    {
        // Relación estándar: muchos detalles pertenecen a un producto
        // Si producto_id es nullable o el producto puede ser libre, esta relación puede ser null.
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
