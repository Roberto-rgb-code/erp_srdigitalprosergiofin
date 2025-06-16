<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoCXP extends Model
{
    protected $table = 'pagos_cxp';
    protected $fillable = [
        'cuenta_por_pagar_id',
        'monto',
        'fecha',
        'tipo',
        'comentarios',
        'comprobante'
    ];

    public function cuentaPorPagar()
    {
        return $this->belongsTo(CuentaPorPagar::class, 'cuenta_por_pagar_id');
    }
}
