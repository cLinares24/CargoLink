<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends User
{
    protected $table = 'users'; // Usan la misma tabla

    protected static function booted()
    {
        static::addGlobalScope('client', function ($query) {
            $query->where('type', 'client');
        });
    }
}
