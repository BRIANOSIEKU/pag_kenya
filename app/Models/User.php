<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles;

    /**
     * We keep role column for backward compatibility (VERY IMPORTANT for now)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Users can make comments on devotions
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_name', 'name');
    }

    /**
     * OPTIONAL HELPER:
     * This helps you slowly migrate from old role system to Spatie
     */
    public function getRoleNameAttribute()
    {
        return $this->role; // old system (ENUM)
    }

    /**
     * OPTIONAL HELPER:
     * Check if user has Spatie role OR fallback to old role system
     */
    public function hasSystemRole($role)
    {
        return $this->hasRole($role) || $this->role === $role;
    }
}