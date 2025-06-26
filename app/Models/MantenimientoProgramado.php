<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MantenimientoProgramado extends Model
{
    use HasFactory;

    protected $table = 'mantenimientos_programados';

    protected $fillable = [
        'servicio_empresarial_id',
        'descripcion',
        'fecha_programada',
        'estado',
        'comentarios',
    ];

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicio_empresarial_id');
    }
}
