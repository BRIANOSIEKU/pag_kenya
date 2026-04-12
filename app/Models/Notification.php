<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_admin_id',
        'title',
        'message',
        'type',
        'is_read',
        'related_id',
    ];

    public function districtAdmin()
    {
        return $this->belongsTo(DistrictAdmin::class);
    }
}