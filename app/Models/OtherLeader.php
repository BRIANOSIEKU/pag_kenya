<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherLeader extends Model
{
    protected $table = 'other_leaders';

    protected $fillable = [
        'department_id',
        'name',
        'position',
        'phone',
        'email',
        'photo',
    ];

    // Relationship → Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}