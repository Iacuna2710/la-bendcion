<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'is_active'            => 'boolean',
            'password_es_temporal' => 'boolean',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'user_roles',
            'id_user',
            'id_roles'
        );
    }

    public function carrito()
    {
        return $this->hasOne(Carrito::class, 'id_user', 'id_user');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_user', 'id_user');
    }

    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'id_user', 'id_user');
    }
    

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
