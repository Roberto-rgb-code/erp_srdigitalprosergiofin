<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientoCxp extends Model
{
    protected $table = 'seguimientos_cxp';

    protected $fillable = [
        'cuenta_pagar_id',
        'fecha',
        'comentario',
        'tipo',             // alerta, aviso, recordatorio, etc.
        'porcentaje_impacto'
    ];

    public function cuentaPorPagar()
    {
        return $this->belongsTo(CuentaPorPagar::class, 'cuenta_pagar_id');
    }
}
