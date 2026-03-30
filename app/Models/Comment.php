<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['devotion_id', 'user_id', 'comment', 'admin_response'];

    public function devotion()
    {
        return $this->belongsTo(Devotion::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}