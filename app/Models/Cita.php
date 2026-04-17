<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'user_id',
        'servicio_id',
        'fecha',
        'hora',
        'estado',
        'notas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
