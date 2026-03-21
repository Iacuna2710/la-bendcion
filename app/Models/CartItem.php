<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo CartItem — ítem individual dentro del carrito de compras.
 * Tabla: cart_items | Clave primaria: id_c_item
 */
class CartItem extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'cart_items';
    protected $primaryKey = 'id_c_item';

    protected $fillable = [
        'id_carrito',
        'id_producto',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'cantidad'        => 'integer',
            'precio_unitario' => 'decimal:2',
            'subtotal'        => 'decimal:2',
        ];
    }

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * El ítem pertenece a un carrito.
     */
    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'id_carrito', 'id_carrito');
    }

    /**
     * El ítem está asociado a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
