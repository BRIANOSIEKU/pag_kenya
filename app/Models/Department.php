<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // A department can have many leaders
    public function leaders()
    {
        return $this->hasMany(Leader::class);
    }
}
