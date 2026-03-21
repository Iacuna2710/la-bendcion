<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo FacturaItem — ítem individual dentro de una factura.
 * Tabla: factura_items | Clave primaria: id_fac_item
 */
class FacturaItem extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'factura_items';
    protected $primaryKey = 'id_fac_item';

    protected $fillable = [
        'id_factura',
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
     * El ítem pertenece a una factura.
     */
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura', 'id_factura');
    }

    /**
     * El ítem está asociado a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
