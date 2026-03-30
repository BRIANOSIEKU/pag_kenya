<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveStream extends Model
{
    use HasFactory;

    protected $table = 'live_streams';

    protected $fillable = [
        'title',
        'type',
        'url',
        'description',
        'logo',       // Added for logo support
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active stream.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}