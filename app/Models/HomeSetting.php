<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $table = 'home_settings';

    protected $fillable = [
        'theme',
        'scripture',
        'hero_heading',
        'hero_subtext'
    ];
}