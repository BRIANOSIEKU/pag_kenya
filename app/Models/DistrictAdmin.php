<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DistrictAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Table name
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
     * Hide sensitive fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * =========================
     * RELATIONSHIP
     * =========================
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * =========================
     * NOTIFICATIONS (Laravel built-in)
     * =========================
     */

    // optional helper (Laravel already provides unreadNotifications)
    public function unreadCount()
    {
        return $this->unreadNotifications()->count();
    }
}