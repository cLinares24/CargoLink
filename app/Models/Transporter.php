<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporter extends User
{
    protected $table = 'users'; // Usan la misma tabla

    protected static function booted()
    {
        static::addGlobalScope('transporter', function ($query) {
            $query->where('type', 'transporter');
        });
    }
    
    // Relación con el modelo Vehicle
    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }
}
