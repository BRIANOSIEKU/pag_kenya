<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'department_id',
        'photo',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
