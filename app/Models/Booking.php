<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_name', 'client_email', 'client_phone',
        'service_id', 'event_date', 'event_location',
        'notes', 'amount', 'status'
    ];

    protected $casts = [
        'event_date' => 'date',
        'amount'     => 'decimal:2',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
