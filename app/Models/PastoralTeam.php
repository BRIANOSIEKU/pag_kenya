<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assembly;

class PastoralTeam extends Model
{
    use HasFactory;

    protected $table = 'pastoral_teams';

    protected $fillable = [
        'name',
        'national_id',
        'gender',
        'contact',
        'graduation_year',
        'date_of_birth',
        'photo',
        'attachments',
        'district_id',
        'assembly_id',
    ];

    // =========================
    // CASTS
    // =========================
    protected $casts = [
        'attachments' => 'array',
        'date_of_birth' => 'date',
    ];

    // =========================
    // RELATIONSHIP (THIS FIXES YOUR ERROR)
    // =========================
    public function assembly()
    {
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }

    // (OPTIONAL BUT USEFUL)
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}