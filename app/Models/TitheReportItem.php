<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheReportItem extends Model
{
    use HasFactory;

    protected $table = 'tithe_report_items';

    protected $fillable = [
        'tithe_report_id',
        'assembly_id',
        'amount',
        'assembly_muhtasari', // ✅ ADDED
    ];

    /**
     * Relationship: Item belongs to report
     */
    public function report()
    {
        return $this->belongsTo(TitheReport::class, 'tithe_report_id');
    }

    /**
     * Relationship: Item belongs to assembly
     */
    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }
}