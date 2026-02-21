<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = 'contact_info';

    protected $fillable = [
        'website_url',
        'official_email',
        'customer_care_number',
        'general_superintendent_pa_number',
        'postal_address',
        'google_map_embed',
        'working_hours',
    ];
}
