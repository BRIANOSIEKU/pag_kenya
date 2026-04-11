<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'assemblies';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'district_id',
        'name',
        'physical_address',
        'status', // pending | approved
    ];

    /**
     * Casts
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |----------------------------------------------------------------------
    | RELATIONSHIPS
    |----------------------------------------------------------------------
    */

    /**
     * Assembly belongs to District
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Assembly has many Pastoral Team members
     */
    public function pastoralTeam()
    {
        return $this->hasMany(PastoralTeam::class);
    }

    /**
     * 🔥 NEW: Assembly has many Tithe Report Items
     */
    public function titheItems()
    {
        return $this->hasMany(TitheReportItem::class, 'assembly_id');
    }

    /**
     * 🔥 OPTIONAL (POWERFUL): Access reports through items
     */
    public function titheReports()
    {
        return $this->hasManyThrough(
            TitheReport::class,
            TitheReportItem::class,
            'assembly_id',          // Foreign key on tithe_report_items
            'id',                   // Foreign key on tithe_reports
            'id',                   // Local key on assemblies
            'tithe_report_id'       // Local key on tithe_report_items
        );
    }

    /*
    |----------------------------------------------------------------------
    | SCOPES
    |----------------------------------------------------------------------
    */

    /**
     * Pending assemblies
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Approved assemblies
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /*
    |----------------------------------------------------------------------
    | HELPERS
    |----------------------------------------------------------------------
    */

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}