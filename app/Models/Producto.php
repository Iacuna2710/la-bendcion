<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
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

   
    public function categorias()
    {
        return $this->belongsToMany(
            Categoria::class,
            'producto_categoria',
            'id_producto',
            'id_categoria'
        );
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto', 'id_producto')
                    ->orderBy('orden');
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(ImagenProducto::class, 'id_producto', 'id_producto')
                    ->where('es_principal', true);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_producto', 'id_producto');
    }

    public function pedidoItems()
    {
        return $this->hasMany(PedidoItem::class, 'id_producto', 'id_producto');
    }

    public function facturaItems()
    {
        return $this->hasMany(FacturaItem::class, 'id_producto', 'id_producto');
    }

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
