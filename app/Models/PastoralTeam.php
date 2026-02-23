<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastoralTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'district_name',
        'assembly_name', // NEW
        'role',
        'phone',
        'email',
        'photo',
    ];
}