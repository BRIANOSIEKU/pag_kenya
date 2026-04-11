<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyLeader extends Model
{
    use HasFactory;

    protected $table = 'assembly_leaders';

    protected $fillable = [
        'assembly_id',
        'name',
        'position',
        'gender',
        'contact',
        'national_id',
        'dob',
        'photo',
        'attachments',
    ];

    /**
     * Relationship: Leader belongs to an Assembly
     */
    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }
}