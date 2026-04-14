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
     * We keep 'role' for backward compatibility (temporary bridge)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Hidden fields for security
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts (recommended for Laravel security & consistency)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Users can make comments on devotions
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_name', 'name');
    }

    /*
    |--------------------------------------------------------------------------
    | ROLE SYSTEM (HYBRID - TEMPORARY)
    |--------------------------------------------------------------------------
    */

    /**
     * OLD ROLE ACCESSOR (for backward compatibility)
     */
    public function getRoleNameAttribute()
    {
        return $this->role;
    }

    /**
     * SAFE ROLE CHECKER (HYBRID SYSTEM)
     * - Uses Spatie first (PRIMARY)
     * - Falls back to old role column (TEMPORARY)
     */
    public function hasSystemRole($role)
    {
        return $this->hasRole($role) ||
               $this->role === $role ||
               $this->role === str_replace('-', '_', $role);
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVAL HELPERS (FOR YOUR PAG SYSTEM)
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user can approve pastoral transfers
     */
    public function canApproveTransfers()
    {
        return $this->hasRole(['super-admin', 'general-superintendent']);
    }

    /**
     * Check if user can approve financial reports
     */
    public function canApproveReports()
    {
        return $this->hasRole(['super-admin', 'general-treasurer']);
    }

    /**
     * Check if user can approve assemblies & teams
     */
    public function canApproveAssemblies()
    {
        return $this->hasRole(['super-admin', 'general-secretary']);
    }

    /**
     * Check if user has full system control
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }
}