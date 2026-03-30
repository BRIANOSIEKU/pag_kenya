<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'file_path',
        'name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
