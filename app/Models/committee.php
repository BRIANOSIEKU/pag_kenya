<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'overview',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the duties associated with the committee.
     */
    public function duties()
    {
        return $this->hasMany(CommitteeDuty::class, 'committee_id');
    }

    /**
     * Get the members belonging to this committee.
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'committee_id');
    }

    /**
     * Get the reports uploaded for this committee.
     * Updated to match the committee_reports table.
     */
    public function reports()
    {
        return $this->hasMany(CommitteeReport::class, 'committee_id');
    }

    /**
     * Get the leaders (Chair, Secretary, etc.) for this committee.
     * This uses the pivot table committee_leader which stores 
     * specific roles, photos, and contacts per committee.
     */
    public function leaders()
    {
        return $this->belongsToMany(Leader::class, 'committee_leader')
                    ->withPivot('role', 'photo', 'contact')
                    ->withTimestamps();
    }
}