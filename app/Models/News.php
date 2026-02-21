<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Allow mass assignment for news fields
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * Relationship: a news post can have many photos
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
