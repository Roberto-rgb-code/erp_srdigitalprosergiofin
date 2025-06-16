<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesarrolloSoftware extends Model
{
    protected $table = 'desarrollo_software';
    protected $fillable = [
        'cliente_id',
        'nombre',
        'tipo_software_id',
        'stack_tecnologico',
        'fecha_inicio',
        'fecha_fin',
        'responsable_id',
        'estado',
        'historial'
    ];
    public $timestamps = false;

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function tipoSoftware()
    {
        return $this->belongsTo(TipoSoftware::class, 'tipo_software_id');
    }

    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }

    public function modulos()
    {
        return $this->hasMany(ModuloSoftware::class, 'desarrollo_software_id');
    }
}
