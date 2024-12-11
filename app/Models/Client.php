<?php

namespace App\Models;

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
