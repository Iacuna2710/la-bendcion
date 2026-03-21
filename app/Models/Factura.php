<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo Factura — facturas generadas automáticamente al confirmar el pago.
 * Tabla: facturas | Clave primaria: id_factura
 * Usa SoftDeletes para eliminación lógica mediante deleted_at.
 */
class Factura extends Model
{
    use SoftDeletes;

    // ── Configuración ────────────────────────────────────────────────────────
    protected $table      = 'facturas';
    protected $primaryKey = 'id_factura';

    protected $fillable = [
        'id_pedido',
        'numero_factura',
        'fecha_emision',
        'subtotal',
        'impuesto',
        'total',
        'estado_factura',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_emision' => 'date',
            'subtotal'      => 'decimal:2',
            'impuesto'      => 'decimal:2',
            'total'         => 'decimal:2',
        ];
    }

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Una factura pertenece a un pedido.
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    /**
     * Una factura tiene muchos ítems de productos.
     */
    public function items()
    {
        return $this->hasMany(FacturaItem::class, 'id_factura', 'id_factura');
    }

    // ── Métodos auxiliares ───────────────────────────────────────────────────

    /**
     * Genera el número de factura con el formato FAC-YYYYMMDD-XXXX.
     * Se debe llamar antes de crear la factura y asignar a numero_factura.
     *
     * @return string
     */
    public static function generarNumeroFactura(): string
    {
        $fecha     = now()->format('Ymd');
        $prefijo   = "FAC-{$fecha}-";
        $ultimo    = static::withTrashed()
                           ->where('numero_factura', 'like', $prefijo . '%')
                           ->orderByDesc('numero_factura')
                           ->value('numero_factura');
        $secuencia = $ultimo ? (int) substr($ultimo, -4) + 1 : 1;

        return $prefijo . str_pad($secuencia, 4, '0', STR_PAD_LEFT);
    }
}
