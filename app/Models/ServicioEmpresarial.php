<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioEmpresarial extends Model
{
    protected $table = 'servicios_empresariales';

    protected $fillable = [
        'cliente_id',
        'poliza_servicio_id',
        'estatus',
        'comentarios'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function poliza()
    {
        return $this->belongsTo(PolizaServicio::class, 'poliza_servicio_id');
    }
}
