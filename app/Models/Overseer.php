<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overseer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'district_name',
        'email',
        'phone',
        'gender',
        'photo',
    ];

    /**
     * Accessor for photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        return asset('images/default-avatar.png'); // fallback image
    }
}