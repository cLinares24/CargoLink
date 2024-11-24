<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    protected $table = 'transporters';
    protected $fillable = [
        'user_id'
    ];
    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    // Relación con el modelo Vehicle
    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }
}
