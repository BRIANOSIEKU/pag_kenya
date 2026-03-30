<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donations';

    protected $fillable = [
        'donor_name',
        'phone_number',
        'amount',
        'mode_of_payment',
        'transaction_id',
    ];

    public $timestamps = false; // We only have created_at, no updated_at
}
