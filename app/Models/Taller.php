<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    protected $table = 'taller';

    protected $fillable = [
        'cliente_id',
        'tipo_cliente',
        'equipo_id',
        'tecnico_id',
        'fecha_ingreso',
        'fecha_entrega',
        'detalle_problema',
        'solucion',
        'observaciones',
        'imei',
        'condicion_fisica',
        'estetica',
        'tipo_bloqueo',
        'zona_trabajo',
        'costo_total',
        'anticipo',
        'firma_cliente',
        'status'
    ];

    public $timestamps = false; // Cambia a true si agregas created_at/updated_at

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id');
    }

    public function equipo()
    {
        return $this->belongsTo(\App\Models\Equipo::class, 'equipo_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(\App\Models\Empleado::class, 'tecnico_id');
    }

    // NUEVAS RELACIONES PARA LOS TABS
    public function refacciones()
    {
        return $this->hasMany(\App\Models\Refaccion::class, 'taller_id');
    }

    public function evidencias()
    {
        return $this->hasMany(\App\Models\Evidencia::class, 'taller_id');
    }

    // Folio virtual (no es columna en la base)
    public function getFolioAttribute()
    {
        return 'OS-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
}
