<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
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
