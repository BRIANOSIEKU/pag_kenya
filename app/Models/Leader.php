<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'email',
        'brief_description',
        'message',
    ];

    /**
     * Many-to-Many: Leader belongs to many Committees
     */
    public function committees()
    {
        return $this->belongsToMany(Committee::class)
                    ->withPivot('role', 'photo', 'contact')
                    ->withTimestamps();
    }

    /**
     * Optional: If you still use departments
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}