<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id',
        'usuario_id',
        'fecha_venta',
        'monto_total',
        'estatus',
        'tipo_venta',
        'comentarios',
    ];

    public $timestamps = false; // Si la tabla no tiene created_at y updated_at

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id');
    }

    // Relación con detalles de venta (detalle_venta)
    public function detalles()
    {
        return $this->hasMany(\App\Models\DetalleVenta::class, 'venta_id');
    }

    // Relación many-to-many con productos (a través de detalle_venta)
    public function productos()
    {
        return $this->belongsToMany(\App\Models\Producto::class, 'detalle_venta', 'venta_id', 'producto_id')
            ->withPivot('cantidad', 'precio_unitario');
    }

    // Relación con pagos
    public function pagos()
    {
        return $this->hasMany(\App\Models\Pago::class, 'venta_id');
    }

    // Accesor para folio formateado (VEN-00001, etc.)
    public function getFolioAttribute()
    {
        return 'VEN-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
}
