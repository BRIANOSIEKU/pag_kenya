<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchCouncil extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'position',
        'contact',
        'email',
        'brief_description',
        'message',
        'photo'
    ];
}
