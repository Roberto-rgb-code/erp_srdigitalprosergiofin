<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CobroCuentaPorCobrar extends Model
{
    use HasFactory;

    protected $table = 'cobros_cuentas_por_cobrar';

    protected $fillable = [
        'cuenta_por_cobrar_id', 'fecha_cobro', 'monto_cobrado', 'recibo', 'observaciones'
    ];

    public function cuenta()
    {
        return $this->belongsTo(CuentaPorCobrar::class, 'cuenta_por_cobrar_id');
    }
}
