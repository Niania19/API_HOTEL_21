<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    /**
     * Relación con el producto.
     * Esto permite que al ver el detalle, Laravel sepa qué producto es.
     */
    public function producto(): BelongsTo
    {
        // 'product_id' es la columna en tu tabla 'order_items'
        return $this->belongsTo(Producto::class, 'product_id');
    }
}