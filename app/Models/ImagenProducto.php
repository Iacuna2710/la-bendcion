<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
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


    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
