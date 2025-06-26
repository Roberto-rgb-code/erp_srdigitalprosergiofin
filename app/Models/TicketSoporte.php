<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSoporte extends Model
{
    use HasFactory;

    protected $table = 'tickets_soporte';

    protected $fillable = [
        'servicio_empresarial_id',
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
        'fecha_apertura',
        'fecha_cierre',
        'asignado_a',
        'comentarios',
    ];

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicio_empresarial_id');
    }
}
