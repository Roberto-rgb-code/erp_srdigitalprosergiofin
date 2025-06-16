<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackCliente extends Model
{
    protected $table = 'feedback_cliente';
    protected $fillable = [
        'modulo_software_id',
        'comentario',
        'fecha'
    ];
    public $timestamps = false;

    // Relaciones
    public function modulo()
    {
        return $this->belongsTo(ModuloSoftware::class, 'modulo_software_id');
    }
}
