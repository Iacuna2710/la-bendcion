<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo EstadoPedido — estados posibles de un pedido.
 * Tabla: estados_pedido | Clave primaria: id_estado_ped
 * Ejemplos: Pendiente, En proceso, Enviado, Entregado, Cancelado.
 */
class EstadoPedido extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
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

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Un estado puede tener muchos pedidos asociados.
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_estado_ped', 'id_estado_ped');
    }
}
