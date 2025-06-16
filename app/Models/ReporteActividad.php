<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteActividad extends Model
{
    protected $table = 'reporte_actividad';

    protected $fillable = [
        'cableado_id',
        'empleado_id',
        'fecha',
        'descripcion',
        'checklist',
        'evidencia'
    ];

    public $timestamps = false;

    public function cableado() {
        return $this->belongsTo(Cableado::class, 'cableado_id');
    }

    public function empleado() {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
