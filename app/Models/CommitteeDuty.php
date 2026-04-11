<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeDuty extends Model
{
    use HasFactory;

    protected $fillable = ['committee_id', 'duty'];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}