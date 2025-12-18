<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'titulo', 
        'descripcion', 
        'lugar', 
        'latitud', 
        'longitud', 
        'fecha', 
        'hora_inicio'
    ];
}
