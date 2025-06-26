<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaChicaMovimiento extends Model
{
    protected $table = 'caja_chica_movimientos';

    protected $fillable = [
        'tipo',
        'monto',
        'descripcion',
        'fecha',
        'comprobante',
        'usuario_id'
    ];

    // Relación con usuarios (si la usas)
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }

    // Accesor para mostrar si es entrada/salida con badge (opcional, para el blade)
    public function getTipoBadgeAttribute()
    {
        if ($this->tipo === 'entrada') {
            return '<span class="badge bg-success">Entrada</span>';
        } else {
            return '<span class="badge bg-danger">Salida</span>';
        }
    }
}
