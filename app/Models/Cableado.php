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
        'responsable_id',
        'costo_estimado',
        'costo_real',
        'estatus',
        'comentarios'
    ];

    public $timestamps = false;

    // Relaciones
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function responsable() {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }
    public function inventario() {
        return $this->hasMany(InventarioProyecto::class, 'cableado_id');
    }
    public function reportes() {
        return $this->hasMany(ReporteActividad::class, 'cableado_id');
    }
}
