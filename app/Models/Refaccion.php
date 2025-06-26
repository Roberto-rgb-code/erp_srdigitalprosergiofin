<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refaccion extends Model
{
    protected $table = 'refacciones';

    protected $fillable = [
        'taller_id',
        'nombre',
        'cantidad',
        'costo',
        'fecha_solicitud',
        'usuario_solicito',
        'usuario_aprobo',
        'situacion'
    ];

    public $timestamps = false; // o true si usas created_at/updated_at

    public function taller()
    {
        return $this->belongsTo(\App\Models\Taller::class, 'taller_id');
    }
}
