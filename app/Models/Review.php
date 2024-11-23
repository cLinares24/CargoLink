<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    // Especifica los atributos que se pueden asignar masivamente
    protected $fillable = [
        'shipment_id',
        'rating',
        'date',
    ];

    // Relación con el modelo Shipment
    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
