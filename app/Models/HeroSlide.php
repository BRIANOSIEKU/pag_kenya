<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $table = 'hero_slides';

    protected $fillable = [
        'image',
        'title',
        'subtitle',
        'sort_order',
        'is_active'
    ];
}