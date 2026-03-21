<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo PedidoItem — ítem individual dentro de un pedido.
 * Tabla: pedido_items | Clave primaria: id_ped_item
 */
class PedidoItem extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'pedido_items';
    protected $primaryKey = 'id_ped_item';

    protected $fillable = [
        'id_pedido',
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
     * El ítem pertenece a un pedido.
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    /**
     * El ítem está asociado a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
