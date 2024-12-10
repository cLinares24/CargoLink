<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'shipments';

    protected $fillable = [
        'client_id',
        'transporter_id',
        'source_address',
        'destination_address',
        'status',
        'current_address',
        'creation_date',
        'estimated_delivery',
    ];

     // Relación con el modelo Client
     public function client()
     {
         return $this->belongsTo(Client::class);
     }
 
     // Relación con el modelo Transporter
     public function transporter()
     {
         return $this->belongsTo(Transporter::class);
     }
 
    // Relación con el modelo Shipment
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

     // Relación con el modelo Pay
     public function pay()
     {
         return $this->hasOne(Pay::class);
     }

     // Relación con el modelo Review
     public function review()
     {
         return $this->hasOne(Review::class);
     }
}
