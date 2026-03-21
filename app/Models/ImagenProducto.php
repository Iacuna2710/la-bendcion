<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo ImagenProducto — imágenes asociadas a un producto.
 * Tabla: imagenes_productos | Clave primaria: id_img_prod
 */
class ImagenProducto extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'imagenes_productos';
    protected $primaryKey = 'id_img_prod';

    protected $fillable = [
        'id_producto',
        'url',
        'alt_text',
        'orden',
        'es_principal',
    ];

    protected function casts(): array
    {
        return [
            'es_principal' => 'boolean',
            'orden'        => 'integer',
        ];
    }

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Una imagen pertenece a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
