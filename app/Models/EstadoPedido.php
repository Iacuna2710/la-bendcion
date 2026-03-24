<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model
{
    protected $table      = 'estados_pedido';
    protected $primaryKey = 'id_estado_ped';

    protected $fillable = [
        'nombre',
        'color',
        'orden',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'orden'     => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_estado_ped', 'id_estado_ped');
    }
}
