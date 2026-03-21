<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo Producto — productos macrobióticos del catálogo.
 * Tabla: productos | Clave primaria: id_producto
 * Usa SoftDeletes para eliminación lógica mediante deleted_at.
 */
class Producto extends Model
{
    use SoftDeletes;

    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'productos';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'stock_minimo',
        'sku',
        'ingredientes',
        'beneficios',
        'es_destacado',
    ];

    protected function casts(): array
    {
        return [
            'precio'       => 'decimal:2',
            'es_destacado' => 'boolean',
            'stock'        => 'integer',
            'stock_minimo' => 'integer',
        ];
    }

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Un producto pertenece a una o más categorías.
     * Tabla pivote: producto_categoria
     */
    public function categorias()
    {
        return $this->belongsToMany(
            Categoria::class,
            'producto_categoria',
            'id_producto',
            'id_categoria'
        );
    }

    /**
     * Un producto puede tener múltiples imágenes.
     */
    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto', 'id_producto')
                    ->orderBy('orden');
    }

    /**
     * Imagen principal del producto (es_principal = true).
     */
    public function imagenPrincipal()
    {
        return $this->hasOne(ImagenProducto::class, 'id_producto', 'id_producto')
                    ->where('es_principal', true);
    }

    /**
     * Un producto puede estar en muchos ítems de carrito.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_producto', 'id_producto');
    }

    /**
     * Un producto puede estar en muchos ítems de pedido.
     */
    public function pedidoItems()
    {
        return $this->hasMany(PedidoItem::class, 'id_producto', 'id_producto');
    }

    /**
     * Un producto puede estar en muchos ítems de factura.
     */
    public function facturaItems()
    {
        return $this->hasMany(FacturaItem::class, 'id_producto', 'id_producto');
    }

    // ── Métodos auxiliares ───────────────────────────────────────────────────

    /**
     * Indica si el stock está en o por debajo del stock mínimo.
     *
     * @return bool
     */
    public function stockBajo(): bool
    {
        return $this->stock <= $this->stock_minimo;
    }
}
