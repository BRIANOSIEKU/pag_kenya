<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'overview',
        'leadership',
        'activities',
        'description',
        'photo', // column for department photo
    ];

    /**
     * Relationship: Department has many documents
     */
    public function documents()
    {
        return $this->hasMany(DepartmentDocument::class); // <-- existing
    }

    /**
     * Relationship: Department has many achievements
     */
    public function achievements()
    {
        return $this->hasMany(DepartmentAchievement::class);
    }
}
