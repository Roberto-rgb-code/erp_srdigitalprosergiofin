<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuloSoftware extends Model
{
    protected $table = 'modulos_software';

    protected $fillable = [
        'desarrollo_software_id',
        'nombre',
        'descripcion',
    ];

    public $timestamps = true;

    public function desarrolloSoftware()
    {
        return $this->belongsTo(\App\Models\DesarrolloSoftware::class, 'desarrollo_software_id');
    }
}
