<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $table      = 'pedidos';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_estado_ped',
        'id_user',
        'id_direccion',
        'num_pedido',
        'subtotal',
        'descuento',
        'impuesto',
        'costo_envio',
        'total',
        'notas',
        'fecha_entrega_esperada',
        'fecha_entrega_real',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'               => 'decimal:2',
            'descuento'              => 'decimal:2',
            'impuesto'               => 'decimal:2',
            'costo_envio'            => 'decimal:2',
            'total'                  => 'decimal:2',
            'fecha_entrega_esperada' => 'date',
            'fecha_entrega_real'     => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }


    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id_direccion', 'id_direccion');
    }


    public function estadoPedido()
    {
        return $this->belongsTo(EstadoPedido::class, 'id_estado_ped', 'id_estado_ped');
    }


    public function items()
    {
        return $this->hasMany(PedidoItem::class, 'id_pedido', 'id_pedido');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_pedido', 'id_pedido');
    }

    public function factura()
    {
        return $this->hasOne(Factura::class, 'id_pedido', 'id_pedido');
    }

    /**
     * Genera el número de pedido con el formato PED-YYYYMMDD-XXXX.
     * Se debe llamar antes de crear el pedido y asignar a num_pedido.
     *
     * @return string
     */
    public static function generarNumeroPedido(): string
    {
        $fecha     = now()->format('Ymd');
        $prefijo   = "PED-{$fecha}-";
        $ultimo    = static::where('num_pedido', 'like', $prefijo . '%')
                           ->orderByDesc('num_pedido')
                           ->value('num_pedido');
        $secuencia = $ultimo ? (int) substr($ultimo, -4) + 1 : 1;

        return $prefijo . str_pad($secuencia, 4, '0', STR_PAD_LEFT);
    }
}
