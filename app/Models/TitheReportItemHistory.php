<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitheReportItemHistory extends Model
{
    use HasFactory;

    protected $table = 'tithe_report_item_histories';

    protected $fillable = [
        'tithe_report_id',
        'assembly_id',
        'amount',
    ];

    /**
     * Relationship: original report
     */
    public function report()
    {
        return $this->belongsTo(TitheReport::class, 'tithe_report_id');
    }

    /**
     * Relationship: assembly
     */
    public function assembly()
    {
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }
}