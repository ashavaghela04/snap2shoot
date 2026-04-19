<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    /**
     * FIXES:
     * - Added 'role' (exists in original migration, was missing from fillable)
     * - Added 'sort_order' (exists in original migration, used in scopeActive but missing from fillable)
     * - All other fields already correct
     */
    protected $fillable = [
        'name',
        'role',           // FIX: was in original migration but missing from fillable
        'designation',
        'email',
        'phone',
        'bio',
        'image_url',
        'instagram_url',
        'facebook_url',
        'twitter_url',
        'experience',
        'is_active',
        'sort_order',     // FIX: used in scopeActive()->orderBy() but missing from fillable
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'experience'  => 'integer',
        'sort_order'  => 'integer',
    ];

    /**
     * Scope to get only active members ordered by sort_order.
     * Used on the public-facing About/Team page.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}