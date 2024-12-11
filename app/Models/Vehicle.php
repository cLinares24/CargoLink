<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = [
        'transporter_id',
        'license_plate',
        'transport_type',
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
