<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchProfile extends Model
{
    use HasFactory;

    // If your table is not the default 'church_profiles', define it:
    // protected $table = 'your_table_name';

    protected $fillable = [
        'motto',
        'vision',
        'mission',
        'core_values',
        'statement_of_faith',
        'overview',
        'history',
    ];
}
