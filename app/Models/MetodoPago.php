<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
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

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_met_pago', 'id_met_pago');
    }
}
