<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'categoria_id',
        'nombre',
        'precio',
        'duracion_minutos',
        'estado'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
