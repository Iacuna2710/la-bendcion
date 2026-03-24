<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
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

    public function canton()
    {
        return $this->belongsTo(Canton::class, 'id_canton', 'id_canton');
    }
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'id_distrito', 'id_distrito');
    }
}
