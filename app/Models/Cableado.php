<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cableado extends Model
{
    protected $table = 'cableado';

    protected $fillable = [
        'cliente_id',
        'nombre_proyecto',
        'tipo_instalacion',
        'direccion',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'responsable',     // <--- Texto
        'costo_estimado',
        'costo_real',
        'estatus',
        'comentarios'
    ];

    public $timestamps = false;

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
