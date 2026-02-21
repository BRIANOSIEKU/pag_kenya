<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'content',
        'date',
        'like_count',
        'thumbnail',
    ];

    // Cast 'date' to a Carbon date object
    protected $casts = [
        'date' => 'date',
    ];

    // A devotion can have many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
