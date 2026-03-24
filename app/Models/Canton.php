<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
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

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'id_provincia', 'id_provincia');
    }


    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'id_canton', 'id_canton');
    }
}
