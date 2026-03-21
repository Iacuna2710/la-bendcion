<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Distrito — distritos de Costa Rica.
 * Tabla: distritos | Clave primaria: id_distrito
 */
class Distrito extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'distritos';
    protected $primaryKey = 'id_distrito';

    protected $fillable = [
        'id_canton',
        'nombre',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Un distrito pertenece a un cantón.
     */
    public function canton()
    {
        return $this->belongsTo(Canton::class, 'id_canton', 'id_canton');
    }

    /**
     * Un distrito puede tener muchas direcciones de entrega.
     */
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'id_distrito', 'id_distrito');
    }
}
