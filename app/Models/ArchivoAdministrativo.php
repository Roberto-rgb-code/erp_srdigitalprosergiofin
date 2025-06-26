<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoAdministrativo extends Model
{
    use HasFactory;

    protected $table = 'archivos_administrativos';

    protected $fillable = [
        'servicio_empresarial_id',
        'tipo_archivo',
        'ruta_archivo',
        'fecha_subida',
        'comentarios',
    ];

    public function servicioEmpresarial()
    {
        return $this->belongsTo(ServicioEmpresarial::class, 'servicio_empresarial_id');
    }
}
