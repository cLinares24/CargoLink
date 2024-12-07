<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    // Especifica los atributos que se pueden asignar masivamente
    protected $fillable = [
        'shipment_id',
        'description',
        'weight',
        'height',
        'width',
        'declared_value',
        'status',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }
}
