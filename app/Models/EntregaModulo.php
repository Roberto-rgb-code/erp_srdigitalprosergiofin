<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaModulo extends Model
{
    protected $table = 'entregas_modulo';
    protected $fillable = [
        'modulo_software_id',
        'descripcion',
        'archivo',
        'version',
        'fecha'
    ];
    public $timestamps = false;

    // Relaciones
    public function modulo()
    {
        return $this->belongsTo(ModuloSoftware::class, 'modulo_software_id');
    }
}
