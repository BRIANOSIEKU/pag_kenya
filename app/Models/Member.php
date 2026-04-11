<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
protected $table = 'committee_members';
    protected $fillable = [
        'committee_id',
        'member_name',
        'member_gender',
        'member_id',
        'phone',
    ];

    // Disable timestamps
    public $timestamps = false;

    // Relationship to Committee
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}