<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'venta_id',
        'producto_servicio',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];
    public $timestamps = false;

    public function venta() {
        return $this->belongsTo(\App\Models\Venta::class, 'venta_id');
    }
}
