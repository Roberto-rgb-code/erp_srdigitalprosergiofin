<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiarioContable extends Model
{
    protected $table = 'diario_contable';

    protected $fillable = [
        'poliza_id',
        'cuenta_contable_id',
        'debe',
        'haber',
        'fecha'
    ];

    public function poliza()
    {
        return $this->belongsTo(PolizaContable::class, 'poliza_id');
    }

    public function cuenta()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
}
