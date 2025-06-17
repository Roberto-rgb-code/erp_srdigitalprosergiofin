<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; // Asegura que apunte a la tabla correcta

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'sku',
        'cantidad',
        'unidad',
        'status',
    ];

    // Relación: un producto puede estar en varias ventas (pivot ProductoVenta)
    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'detalle_ventas', 'producto_id', 'venta_id')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }
}
