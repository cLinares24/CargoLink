<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    protected $table = 'pays';

    // Especifica los atributos que se pueden asignar masivamente
    protected $fillable = [
        'shipment_id',
        'transaction_id',
        'status',
        'amount',
        'payment_method',
    ];

    // Relación con el modelo Shipment
    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
