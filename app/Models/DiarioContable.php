<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiarioContable extends Model
{
    protected $table = 'diario_contable';

    protected $fillable = [
        'poliza_contable_id', 'cuenta_contable_id', 'fecha', 'concepto', 'debe', 'haber', 'referencia'
    ];

    public function poliza()
    {
        return $this->belongsTo(PolizaContable::class, 'poliza_contable_id');
    }

    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
}
