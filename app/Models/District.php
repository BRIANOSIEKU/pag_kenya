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
     * District has many Pastoral Team members
     */
    public function pastoralTeam()
    {
        return $this->hasMany(PastoralTeam::class);
    }

    /**
     * 🔥 NEW: District has many Tithe Reports
     */
    public function titheReports()
    {
        return $this->hasMany(TitheReport::class);
    }

    /*
    |----------------------------------------------------------------------
    | HELPERS (OPTIONAL BUT POWERFUL)
    |----------------------------------------------------------------------
    */

    /**
     * Get only approved assemblies
     */
    public function approvedAssemblies()
    {
        return $this->assemblies()->where('status', 'approved');
    }
}