<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assembly;
use App\Models\District;

class PastoralTeam extends Model
{
    use HasFactory;

    protected $table = 'pastoral_teams';

    // ✅ FIXED: match database column names
    protected $fillable = [
        'name',
        'national_id',
        'gender',
        'contact',
        'graduation_year', // ✅ FIXED (was year_of_graduation)
        'date_of_birth',
        'photo',
        'attachments',
        'district_id',
        'assembly_id',
    ];

    protected $casts = [
        'attachments' => 'array',
        'date_of_birth' => 'date',
        'graduation_year' => 'integer',
    ];

    // =========================
    // PHOTO URL
    // =========================
    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-user.png');
    }

    // =========================
    // AGE (from DOB)
    // =========================
    public function getAgeAttribute()
    {
        return $this->date_of_birth
            ? $this->date_of_birth->age
            : null;
    }

    // =========================
    // YEAR OF BIRTH (from DOB)
    // =========================
    public function getYearOfBirthAttribute()
    {
        return $this->date_of_birth
            ? $this->date_of_birth->format('Y')
            : null;
    }

    // =========================
    // RELATIONSHIPS
    // =========================
    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // =========================
    // OPTIONAL: FRIENDLY ACCESSOR
    // (so old code still works if needed)
    // =========================
    public function getYearOfGraduationAttribute()
    {
        return $this->graduation_year;
    }
}