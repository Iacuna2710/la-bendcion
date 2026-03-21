<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo MetodoPago — métodos de pago disponibles en el sistema.
 * Tabla: metodos_pago | Clave primaria: id_met_pago
 * Ejemplos: SINPE Móvil, Depósito bancario, Efectivo al entregar.
 */
class MetodoPago extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'metodos_pago';
    protected $primaryKey = 'id_met_pago';

    protected $fillable = [
        'nombre',
        'descripcion',
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
     * Un método de pago puede estar asociado a muchos pagos.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_met_pago', 'id_met_pago');
    }
}
