<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
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

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_met_pago', 'id_met_pago');
    }
}
