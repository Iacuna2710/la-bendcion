<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Canton — cantones de Costa Rica.
 * Tabla: cantones | Clave primaria: id_canton
 */
class Canton extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'cantones';
    protected $primaryKey = 'id_canton';

    protected $fillable = [
        'id_provincia',
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
     * Un cantón pertenece a una provincia.
     */
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'id_provincia', 'id_provincia');
    }

    /**
     * Un cantón tiene muchos distritos.
     */
    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'id_canton', 'id_canton');
    }
}
