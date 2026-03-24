<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Carrito — carrito de compras persistente por usuario.
 * Tabla: carritos | Clave primaria: id_carrito
 * Cada usuario tiene exactamente un carrito (relación 1 a 1).
 */
class Carrito extends Model
{
    protected $table      = 'carritos';
    protected $primaryKey = 'id_carrito';

    protected $fillable = [
        'id_user',
        'descuento',
        'subtotal',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'descuento' => 'decimal:2',
            'subtotal'  => 'decimal:2',
            'total'     => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_carrito', 'id_carrito');
    }
}
