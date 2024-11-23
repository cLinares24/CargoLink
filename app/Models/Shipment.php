<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'shipments';

    protected $fillable = [
        'client_id',
        'transporter_id',
        'package_id',
        'source_address',
        'destination_address',
        'status',
        'amount',
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
 
     // Relación con el modelo Package
     public function package()
     {
         return $this->belongsTo(Package::class);
     }
}
