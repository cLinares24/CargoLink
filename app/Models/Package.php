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
        'dimensions',
        'declared_value',
        'destination',
        'status',
    ];

    // Relación con el modelo Shipment
    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
