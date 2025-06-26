<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoCxp extends Model
{
    protected $table = 'pagos_cxp';

    protected $fillable = [
        'cuenta_pagar_id',
        'fecha_pago',
        'monto',
        'comprobante_path',
        'comentarios'
    ];

    public function cuentaPorPagar()
    {
        return $this->belongsTo(CuentaPorPagar::class, 'cuenta_pagar_id');
    }
}
