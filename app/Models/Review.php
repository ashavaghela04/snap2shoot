<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'client_name',
        'client_email',
        'event_type',
        'event_location',
        'event_year',
        'rating',
        'review_text',
        'client_image_url',
        'status',
    ];

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function getStarsHtmlAttribute(): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $this->rating
                ? '<i class="fas fa-star"></i>'
                : '<i class="far fa-star"></i>';
        }
        return $html;
    }
}