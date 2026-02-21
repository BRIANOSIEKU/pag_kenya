<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executive extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'position',
        'photo',
        'contact',
        'email',
        'brief_description',
        'message',
    ];
}
