<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepartmentUpcomingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'title',
        'event_date',
        'description',
        'file',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}