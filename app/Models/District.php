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
    |----------------------------------------------------------------------
    | RELATIONSHIPS
    |----------------------------------------------------------------------
    */

    /**
     * District has many Assemblies
     */
    public function assemblies()
    {
        return $this->hasMany(Assembly::class);
    }

    /**
     * 🔥 FIXED: Pastoral Team (CURRENT ASSIGNMENT)
     * This is IMPORTANT because your table has:
     * current_district_id
     */
    public function pastoralTeam()
    {
        return $this->hasMany(
            PastoralTeam::class,
            'current_district_id'
        );
    }

    /**
     * Optional: legacy relationship (if still using old field)
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
     * District leaders (Overseer, Secretary, etc.)
     */
    public function leaders()
    {
        return $this->hasMany(DistrictLeader::class);
    }

    /**
     * Direct access to Overseer only
     */
    public function overseer()
    {
        return $this->hasOne(DistrictLeader::class)
            ->where('position', 'Overseer');
    }

    /*
    |----------------------------------------------------------------------
    | HELPERS
    |----------------------------------------------------------------------
    */

    /**
     * Get only approved assemblies
     */
    public function approvedAssemblies()
    {
        return $this->assemblies()->where('status', 'approved');
    }

    /**
     * Total tithe amount
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