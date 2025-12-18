<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ugel extends Model
{
        // Permitimos que el campo 'nombre' sea llenado masivamente
        protected $fillable = ['nombre'];

        // Relación opcional por si luego quieres saber cuántos usuarios tiene una UGEL
        public function users()
        {
            return $this->hasMany(User::class, 'ugel_id');
        }
}
