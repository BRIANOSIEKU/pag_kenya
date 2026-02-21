<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationInstruction extends Model
{
    use HasFactory;

    protected $table = 'donation_instructions';

    protected $fillable = [
        'mode_of_payment',
        'account_name',
        'account_number',
        'instruction',
        'message',
        'image', 
    ];
}
