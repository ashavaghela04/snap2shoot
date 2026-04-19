<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'wedding_date',
        'service_interest', 'message', 'newsletter', 'is_read'
    ];

    protected $casts = [
        'newsletter'   => 'boolean',
        'is_read'      => 'boolean',
        'wedding_date' => 'date',
    ];
}
