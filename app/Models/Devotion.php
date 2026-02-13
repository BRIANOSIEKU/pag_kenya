<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'date',
    ];

    // A devotion can have many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
