<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'proveedor_id',
        'descripcion',
        'monto',
        'fecha_compra',
        'metodo_pago',
        'factura',
        'comentarios'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
