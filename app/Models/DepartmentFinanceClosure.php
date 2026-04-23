<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentFinanceClosure extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'year',
        'month',
        'opening_balance',
        'closing_balance',
        'is_closed',
    ];
}