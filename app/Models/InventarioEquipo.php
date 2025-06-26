<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioEquipo extends Model
{
    use HasFactory;

    protected $table = 'inventario_equipos';

    protected $fillable = [
        'servicio_empresarial_id',
        'tipo_equipo',
        'marca',
        'modelo',
        'numero_serie',
        'descripcion',
        'estado',
        'fecha_registro',
    ];

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicio_empresarial_id');
    }
}
