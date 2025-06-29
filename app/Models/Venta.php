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

    // Relación con detalles de venta
    public function detalles()
    {
        return $this->hasMany(\App\Models\DetalleVenta::class, 'venta_id');
    }

    // Relación con pagos
    public function pagos()
    {
        return $this->hasMany(\App\Models\Pago::class, 'venta_id');
    }

    // Atributo accesor para folio formateado
    public function getFolioAttribute()
    {
        return 'VEN-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
}
