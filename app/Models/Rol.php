<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id_roles';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_roles',
            'id_roles',
            'id_user'
        );
    }
}
