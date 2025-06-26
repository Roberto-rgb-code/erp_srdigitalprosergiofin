<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $table = 'creditos';

    protected $fillable = [
        'cliente_id', 'saldo_actual', 'linea_total', 'linea_usada',
        'status_credito', 'tiempo_credito', 'semaforo', 'especificaciones'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoCredito::class, 'credito_id');
    }

    // Si tienes relación con cobranza
    public function cobros()
    {
        return $this->hasMany(Cobranza::class, 'credito_id');
    }

    public function getLineaLibreAttribute()
    {
        return $this->linea_total - $this->linea_usada;
    }
}

