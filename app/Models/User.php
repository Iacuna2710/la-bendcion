<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo User — adaptado a la tabla `users` de La Bendición.
 * Clave primaria personalizada: id_user.
 * Soporte de eliminación lógica con deleted_at.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    // ────────────────────────────────────────────────────────────────────────
    // Configuración de tabla y clave primaria personalizada
    // ────────────────────────────────────────────────────────────────────────

    /** Nombre de la tabla en la base de datos */
    protected $table = 'users';

    /** Clave primaria personalizada (no sigue la convención 'id' de Laravel) */
    protected $primaryKey = 'id_user';

    // ────────────────────────────────────────────────────────────────────────
    // Atributos asignables masivamente
    // ────────────────────────────────────────────────────────────────────────

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'identificacion',
        'is_active',
        'password_es_temporal',
        'email_verified_at',
    ];

    // ────────────────────────────────────────────────────────────────────────
    // Atributos ocultos en la serialización
    // ────────────────────────────────────────────────────────────────────────

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ────────────────────────────────────────────────────────────────────────
    // Casts de atributos
    // ────────────────────────────────────────────────────────────────────────

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'is_active'            => 'boolean',
            'password_es_temporal' => 'boolean',
        ];
    }

    // ────────────────────────────────────────────────────────────────────────
    // Relaciones
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Un usuario puede tener múltiples roles.
     * Tabla pivote: user_roles | FK del usuario: id_user | FK del rol: id_roles
     */
    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'user_roles',   // tabla pivote
            'id_user',      // FK que apunta a este modelo en la pivote
            'id_roles'      // FK que apunta al modelo relacionado en la pivote
        );
    }

    /**
     * Un usuario tiene exactamente un carrito persistente.
     */
    public function carrito()
    {
        return $this->hasOne(Carrito::class, 'id_user', 'id_user');
    }

    /**
     * Un usuario puede tener muchos pedidos.
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_user', 'id_user');
    }

    /**
     * Un usuario puede tener muchas direcciones de entrega.
     */
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'id_user', 'id_user');
    }

    // ────────────────────────────────────────────────────────────────────────
    // Métodos auxiliares
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Verifica si el usuario tiene un rol específico.
     *
     * @param  string  $rol  Nombre del rol a verificar (ej: 'admin', 'cliente')
     * @return bool
     */
    public function hasRole(string $rol): bool
    {
        return $this->roles()->where('nombre', $rol)->exists();
    }

    /**
     * Verifica si el usuario tiene al menos uno de los roles indicados.
     *
     * @param  array  $roles  Lista de nombres de roles
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('nombre', $roles)->exists();
    }
}
