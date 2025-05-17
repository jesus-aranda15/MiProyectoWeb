<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $casts = [
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_fin' => 'date:Y-m-d',
    ];
    
    protected $fillable = [
        'nombre_periodo',
        'fecha_inicio',
        'fecha_fin',
        'estatus'
    ];

    public function maestros()
{
    return $this->belongsToMany(Maestro::class, 'periodo_maestro')
               ->withTimestamps();
}

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
    
}
