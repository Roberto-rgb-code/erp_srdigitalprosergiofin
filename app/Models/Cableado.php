<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cableado extends Model
{
    use HasFactory;

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
        'comentarios',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con Empleado (responsable)
    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }

    public function balances()
{
    return $this->hasMany(BalanceCableado::class);
}

}
