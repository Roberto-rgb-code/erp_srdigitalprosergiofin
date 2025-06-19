<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolizaContable extends Model
{
    protected $table = 'polizas_contables'; // plural correcto

    protected $fillable = [
        'folio',
        'fecha',
        'tipo_politica',
        'descripcion',
    ];
}
