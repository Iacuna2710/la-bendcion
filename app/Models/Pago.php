<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Pago — registros de pago asociados a los pedidos.
 * Tabla: pagos | Clave primaria: id_pago
 */
class Pago extends Model
{
    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_met_pago',
        'id_pedido',
        'monto',
        'estado',
        'referencia',
        'detalles',
        'fecha_procesamiento',
    ];

    protected function casts(): array
    {
        return [
            'monto'               => 'decimal:2',
            'fecha_procesamiento' => 'datetime',
        ];
    }

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * El pago está asociado a un pedido.
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    /**
     * El pago usa un método de pago específico.
     */
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_met_pago', 'id_met_pago');
    }
}
