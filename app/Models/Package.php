<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    // Especifica los atributos que se pueden asignar masivamente
    protected $fillable = [
        'description',
        'weight',
        'height',
        'width',
        'declared_value',
        'status',
    ];

    // Relación con el modelo Shipment
    public function shipment()
    {
        return $this->hasMany(Shipment::class);
    }
}
