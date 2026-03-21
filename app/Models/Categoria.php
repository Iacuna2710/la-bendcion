<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Categoria — categorías de productos macrobióticos.
 * Tabla: categorias | Clave primaria: id_categoria
 */
class Categoria extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre',
        'descripcion',
        'slug',
        'imagen',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Una categoría puede contener muchos productos.
     * Tabla pivote: producto_categoria
     */
    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'producto_categoria',
            'id_categoria',
            'id_producto'
        );
    }
}
