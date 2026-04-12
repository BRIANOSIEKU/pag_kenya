<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastoralTransfer extends Model
{
    protected $fillable = [
        'pastoral_team_id',
        'from_district_id',
        'from_assembly_id',
        'to_district_id',
        'to_assembly_id',
        'transfer_date',
        'reason',
        'status',
        'rejection_reason',

        // =========================
        // APPROVAL FIELDS (MISSING BEFORE)
        // =========================
        'from_district_approved',
        'to_district_approved',
        'main_admin_approved',
    ];

    // =========================
    // PASTOR
    // =========================
    public function pastor()
    {
        return $this->belongsTo(PastoralTeam::class, 'pastoral_team_id');
    }

    // =========================
    // FROM DISTRICT
    // =========================
    public function fromDistrict()
    {
        return $this->belongsTo(District::class, 'from_district_id');
    }

    // =========================
    // TO DISTRICT
    // =========================
    public function toDistrict()
    {
        return $this->belongsTo(District::class, 'to_district_id');
    }

    // =========================
    // FROM ASSEMBLY
    // =========================
    public function fromAssembly()
    {
        return $this->belongsTo(Assembly::class, 'from_assembly_id');
    }

    // =========================
    // TO ASSEMBLY
    // =========================
    public function toAssembly()
    {
        return $this->belongsTo(Assembly::class, 'to_assembly_id');
    }
}