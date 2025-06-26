<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoAdministrativo extends Model
{
    protected $table = 'documentos_administrativos';

    protected $fillable = [
        'cliente_id', 'poliza_servicio_id', 'tipo_documento', 'archivo', 'fecha', 'comentarios'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function poliza()
    {
        return $this->belongsTo(PolizaServicio::class, 'poliza_servicio_id');
    }
}
