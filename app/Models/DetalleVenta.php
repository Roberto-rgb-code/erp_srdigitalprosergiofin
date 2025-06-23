<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'venta_id',
        'sku',
        'no_serie',
        'nombre_producto',   // <--- este es el correcto para lo que usas
        'precio_costo',
        'precio_venta',
        'cantidad',
        'subtotal',
    ];

    public $timestamps = false; // Si tu tabla no tiene created_at/updated_at

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'sku', 'sku');
    }
}
