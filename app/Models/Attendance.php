<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id', 
        'meeting_id', 
        'entrada', 
        'salida', 
        'estado' // <--- DEBE ESTAR AQUÍ
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function meeting() {
        return $this->belongsTo(Meeting::class);
    }
}
