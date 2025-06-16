<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuloSoftware extends Model
{
    protected $table = 'modulos_software';
    protected $fillable = [
        'desarrollo_software_id',
        'nombre',
        'porcentaje_avance',
        'fase'
    ];
    public $timestamps = false;

    // Relaciones
    public function proyecto()
    {
        return $this->belongsTo(DesarrolloSoftware::class, 'desarrollo_software_id');
    }

    public function entregas()
    {
        return $this->hasMany(EntregaModulo::class, 'modulo_software_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(FeedbackCliente::class, 'modulo_software_id');
    }
}
