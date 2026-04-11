<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictLeader extends Model
{
    use HasFactory;

    protected $table = 'district_leaders';

    protected $fillable = [
        'district_id',
        'name',
        'position',
        'gender',
        'contact',
        'national_id',
        'dob',
        'photo',
        'attachments',
    ];

    protected $casts = [
        'dob' => 'date',
        'attachments' => 'array',
    ];

    /*
    |----------------------------------------------------
    | RELATIONSHIP: District
    |----------------------------------------------------
    */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}