<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyMember extends Model
{
    use HasFactory;

    protected $table = 'assembly_members';

    protected $fillable = [
        'assembly_id',
        'name',
        'gender',
        'contact',
    ];

    /**
     * Each member belongs to an Assembly
     */
    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }
}