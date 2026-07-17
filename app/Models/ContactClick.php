<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactClick extends Model
{
    protected $fillable = [
        'type',
        'value',
        'page_url',
        'ip_address',
        'country',
    ];
}
