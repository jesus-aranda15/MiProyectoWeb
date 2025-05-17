<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'maestro_id',
        'periodo_id',
        'fecha',
        'asistio',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];
    

    public function maestro()
    {
        return $this->belongsTo(Maestro::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }


    
}
