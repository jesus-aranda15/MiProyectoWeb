<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maestro extends Model
{
    protected $fillable = ['matricula', 'nombre_completo', 'departamento', 'correo', 'telefono'];

    public function periodos()
{
    return $this->belongsToMany(Periodo::class, 'periodo_maestro')
               ->withTimestamps();
}

public function asistencias()
{
    return $this->hasMany(Asistencia::class);
}



}
