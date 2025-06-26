<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoVentaMovimiento extends Model
{
    protected $table = 'punto_venta_movimientos';

    protected $fillable = [
        'tipo',
        'monto',
        'descripcion',
        'fecha',
        'comprobante',
        'usuario_id'
    ];

    // Relación con usuarios (opcional)
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }
}
