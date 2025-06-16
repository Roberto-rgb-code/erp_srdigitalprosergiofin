<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';
    protected $fillable = [
        'tipo', 'marca', 'modelo', 'color', 'imei',
        'condicion_fisica', 'estetica', 'tipo_bloqueo', 'zona_trabajo'
    ];
    public $timestamps = false;
}
