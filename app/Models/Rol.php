<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Rol — representa los roles del sistema (admin, trabajador, cliente).
 * Tabla: roles | Clave primaria: id_roles
 */
class Rol extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'roles';
    protected $primaryKey = 'id_roles';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Un rol puede pertenecer a muchos usuarios.
     * Tabla pivote: user_roles | FK del rol: id_roles | FK del usuario: id_user
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_roles',
            'id_roles',
            'id_user'
        );
    }
}
