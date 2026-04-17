<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'hora_inicio',
        'hora_fin',
        'activo'
    ];
}
