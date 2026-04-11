<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeReport extends Model
{
    use HasFactory;

    // Disable Laravel timestamps
    public $timestamps = false;

    protected $fillable = [
        'committee_id',
        'title',
        'attachment',
        'report_date',
        'description',
    ];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}