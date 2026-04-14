<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = [
        'name',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * District has many Assemblies
     */
    public function assemblies()
    {
        return $this->hasMany(Assembly::class);
    }

    /**
     * Pastoral Team (current assignment)
     */
    public function pastoralTeam()
    {
        return $this->hasMany(
            PastoralTeam::class,
            'current_district_id'
        );
    }

    /**
     * Legacy pastoral team relationship (if still used)
     */
    public function pastoralTeamLegacy()
    {
        return $this->hasMany(
            PastoralTeam::class,
            'district_id'
        );
    }

    /**
     * District has many Tithe Reports
     */
    public function titheReports()
    {
        return $this->hasMany(TitheReport::class);
    }

    /**
     * District has many leaders (Overseer, Secretary, etc.)
     */
    public function leaders()
    {
        return $this->hasMany(DistrictLeader::class);
    }

    /**
     * ✅ SINGLE Overseer (FIXED)
     */
    public function overseer()
    {
        return $this->hasOne(DistrictLeader::class)
            ->where('position', 'Overseer');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (CLEAN BLADE USAGE)
    |--------------------------------------------------------------------------
    */

    /**
     * Get Overseer name safely
     */
    public function getOverseerNameAttribute()
    {
        return $this->overseer->name ?? 'Not Assigned';
    }

    /**
     * Get Overseer contact safely
     */
    public function getOverseerContactAttribute()
    {
        return $this->overseer->contact ?? 'N/A';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Get only approved assemblies
     */
    public function approvedAssemblies()
    {
        return $this->assemblies()->where('status', 'approved');
    }

    /**
     * Total tithe amount for district
     */
    public function totalTithe()
    {
        return $this->titheReports()
            ->where('status', 'approved')
            ->sum('total_amount');
    }

    /**
     * Pending reports count
     */
    public function pendingReportsCount()
    {
        return $this->titheReports()
            ->where('status', 'pending')
            ->count();
    }
}