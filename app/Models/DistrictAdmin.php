<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictAdmin extends Model
{
    use HasFactory;

    /**
     * Table name (IMPORTANT since it's not 'district_admins' default guess-safe)
     */
    protected $table = 'district_admins';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'district_id',
        'username',
        'password',
    ];

    /**
     * Hide sensitive fields when returning JSON / arrays
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relationship: DistrictAdmin belongs to a District
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}