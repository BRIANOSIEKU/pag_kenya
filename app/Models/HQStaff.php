<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqStaff extends Model
{
    use HasFactory;

    // Explicit table name
    protected $table = 'hq_staffs';

    // Mass assignable fields
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
