<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = [
        'transport_id',
        'license_plate',
        'transportType',
        'brand',
        'model',
        'year',
        'status',
    ];
    // Relación con el modelo Transporter
    public function transporter()
    {
        return $this->belongsTo(Transporter::class, 'transport_id');
    }
}
