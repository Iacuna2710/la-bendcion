<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
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

    public function cantones()
    {
        return $this->hasMany(Canton::class, 'id_provincia', 'id_provincia');
    }
}
