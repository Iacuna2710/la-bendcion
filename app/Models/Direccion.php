<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table      = 'direcciones';
    protected $primaryKey = 'id_direccion';

    protected $fillable = [
        'id_user',
        'id_distrito',
        'es_principal',
        'detalle',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'es_principal' => 'boolean',
            'is_active'    => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'id_distrito', 'id_distrito');
    }
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_direccion', 'id_direccion');
    }
}
