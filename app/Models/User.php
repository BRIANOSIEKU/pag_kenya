<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles;

    /**
     * Mass assignable fields
     * NOTE: Removed 'role' to fully rely on Spatie
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Hidden fields for arrays
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_name', 'name');
    }

    /*
    |--------------------------------------------------------------------------
    | ROLE HELPERS (SPATIE ONLY)
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check if user is general secretary
     */
    public function isSecretary()
    {
        return $this->hasRole('general_secretary');
    }

    /**
     * Check if user is treasurer
     */
    public function isTreasurer()
    {
        return $this->hasRole('general_treasurer');
    }

    /**
     * Check if user is superintendent
     */
    public function isSuperintendent()
    {
        return $this->hasRole('general_superintendent');
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVAL PERMISSIONS (ROLE-BASED)
    |--------------------------------------------------------------------------
    */

    /**
     * Pastoral transfers approval
     */
    public function canApproveTransfers()
    {
        return $this->hasAnyRole([
            'super_admin',
            'general_superintendent'
        ]);
    }

    /**
     * Financial reports approval
     */
    public function canApproveReports()
    {
        return $this->hasAnyRole([
            'super_admin',
            'general_treasurer'
        ]);
    }

    /**
     * Assemblies & administrative approvals
     */
    public function canApproveAssemblies()
    {
        return $this->hasAnyRole([
            'super_admin',
            'general_secretary'
        ]);
    }

    /**
     * Full system access
     */
    public function hasFullAccess()
    {
        return $this->hasRole('super_admin');
    }
}