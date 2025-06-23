<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_completo',
        'empresa',
        'contacto',
        'direccion',
        'tipo_cliente',
        'status',
        // agrega otros campos si los usas
    ];

    // Relación uno a uno con datos fiscales
    public function datoFiscal()
    {
        return $this->hasOne(DatoFiscalCliente::class, 'cliente_id');
    }

    // Relación uno a muchos con ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }
}
