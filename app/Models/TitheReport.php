<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheReport extends Model
{
    use HasFactory;

    protected $table = 'tithe_reports';

    protected $fillable = [
        'district_id',
        'year',
        'month',
        'payment_code',
        'total_amount',
        'receipt',
        'status',
    ];

    // =========================
    // RELATIONSHIPS
    // =========================

    // Report belongs to a district
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // Report has many items (assemblies)
    public function items()
    {
        return $this->hasMany(TitheReportItem::class);
    }
}