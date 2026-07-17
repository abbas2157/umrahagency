<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'departure_airport',
        'departure_date',
        'hotel_category',
        'duration',
        'travelers',
        'name',
        'phone',
        'email',
        'message',
    ];
}
