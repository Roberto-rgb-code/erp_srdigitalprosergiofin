<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $table = 'cobros';

    protected $fillable = [
        'cuenta_por_cobrar_id',
        'monto',
        'fecha',
        'tipo',
        'comentarios',
        'recibo'
    ];

    public function cuentaPorCobrar()
    {
        return $this->belongsTo(CuentaPorCobrar::class, 'cuenta_por_cobrar_id');
    }
}
