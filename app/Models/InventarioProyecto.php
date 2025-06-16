<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioProyecto extends Model
{
    protected $table = 'inventario_proyecto';

    protected $fillable = [
        'cableado_id',
        'nombre_material',
        'cantidad',
        'unidad'
    ];

    public $timestamps = false;

    public function cableado() {
        return $this->belongsTo(Cableado::class, 'cableado_id');
    }
}
