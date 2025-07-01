<?php

// app/Models/DatoFiscalCliente.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatoFiscalCliente extends Model
{
    protected $fillable = [
        'cliente_id', 'nombre_fiscal', 'rfc', 'direccion_fiscal', 'uso_cfdi', 'correo', 'regimen_fiscal'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}

