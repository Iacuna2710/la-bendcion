<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Direccion — direcciones de entrega de los clientes.
 * Tabla: direcciones | Clave primaria: id_direccion
 */
class Direccion extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
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

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Una dirección pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Una dirección pertenece a un distrito.
     */
    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'id_distrito', 'id_distrito');
    }

    /**
     * Una dirección puede estar asociada a muchos pedidos.
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_direccion', 'id_direccion');
    }
}
