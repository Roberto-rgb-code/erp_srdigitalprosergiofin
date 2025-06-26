<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoCredito extends Model
{
    protected $table = 'documentos_credito';
    protected $fillable = [
        'credito_id', 'tipo_documento', 'archivo', 'fecha_subida'
    ];

    public function credito()
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }
}
