<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheReportHistory extends Model
{
    use HasFactory;

    protected $table = 'tithe_report_histories';

    protected $fillable = [
        'tithe_report_id',
        'year',
        'month',
        'payment_code',
        'total_amount',
        'status',
        'rejection_reason',
        'archived_at',
    ];

    /**
     * Relationship: original report
     */
    public function report()
    {
        return $this->belongsTo(TitheReport::class, 'tithe_report_id');
    }
}