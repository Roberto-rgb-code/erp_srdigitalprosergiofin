<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $table = 'evidencias';

    protected $fillable = [
        'taller_id',
        'archivo',
        'descripcion',
        'usuario_subio',
        'created_at', // si usas timestamps manuales
    ];

    public $timestamps = false; // o true si tu tabla tiene created_at/updated_at

    public function taller()
    {
        return $this->belongsTo(\App\Models\Taller::class, 'taller_id');
    }
}
