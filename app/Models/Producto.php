<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'folio',
        'documento_compra',
        'proveedor_id',
        'tipo_producto',
        'cantidad',
        'producto',
        'sku',
        'numero_serie',
        'costo_unitario',
        'precio_venta',
        'precio_mayoreo',
        'costo_total'
    ];

    // Relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación many-to-many con ventas (a través de detalle_venta)
    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'detalle_venta', 'producto_id', 'venta_id')
            ->withPivot('cantidad', 'precio_unitario');
    }

    // Genera folio automático
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($producto) {
            if (empty($producto->folio)) {
                $lastId = self::max('id') + 1;
                $producto->folio = 'PROD-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}
