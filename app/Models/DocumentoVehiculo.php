<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoVehiculo extends Model
{
    protected $table = 'documentos_vehiculo';
    protected $fillable = [
        'vehiculo_id', 'tipo', 'archivo', 'fecha'
    ];
    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
}
