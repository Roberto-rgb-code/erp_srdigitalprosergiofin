<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaChica extends Model
{
    protected $table = 'caja_chica';

    protected $fillable = [
        'fecha',
        'tipo',
        'monto',
        'responsable_id',
        'comprobante',
        'comentarios'
    ];
}
