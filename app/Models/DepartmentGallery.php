<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentGallery extends Model
{
    use HasFactory;

    // Table name (optional if using default 'department_galleries')
    protected $table = 'department_galleries';

    // Mass assignable fields
    protected $fillable = [
        'department_id',
        'image_path',
    ];

    /**
     * Relationship: Each gallery image belongs to a department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}