<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    protected $table = 'taller';
    protected $fillable = [
        'cliente_id', 'tipo_cliente', 'equipo_id', 'tecnico_id', 'fecha_ingreso',
        'fecha_entrega', 'detalle_problema', 'solucion', 'observaciones', 'imei',
        'condicion_fisica', 'estetica', 'tipo_bloqueo', 'zona_trabajo', 'costo_total',
        'anticipo', 'firma_cliente', 'status'
    ];
    public $timestamps = false;

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
    public function getFolioAttribute()
    {
        return 'OS-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
}
