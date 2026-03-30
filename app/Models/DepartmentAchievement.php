<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'photo',
        'name',
        'description',
        'date',
    ];

    // Relation back to department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
