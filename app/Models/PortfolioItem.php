<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PortfolioItem extends Model
{
    protected $fillable = [
        'title', 'location', 'category', 'image_path',
        'description', 'is_featured', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    /**
     * Accessor: $item->image_url returns a full public URL.
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public static function categories(): array
    {
        return ['wedding', 'prewedding', 'maternity', 'engagement', 'traditional'];
    }
}