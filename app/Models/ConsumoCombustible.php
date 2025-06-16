<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumoCombustible extends Model
{
    protected $table = 'consumo_combustible';
    protected $fillable = [
        'vehiculo_id', 'litros', 'monto', 'fecha', 'ticket'
    ];
    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
}
