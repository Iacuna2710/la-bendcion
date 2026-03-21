<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Provincia — provincias de Costa Rica.
 * Tabla: provincias | Clave primaria: id_provincia
 */
class Provincia extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'provincias';
    protected $primaryKey = 'id_provincia';

    protected $fillable = [
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
     * Una provincia tiene muchos cantones.
     */
    public function cantones()
    {
        return $this->hasMany(Canton::class, 'id_provincia', 'id_provincia');
    }
}
