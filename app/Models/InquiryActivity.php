<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InquiryActivity extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'inquiry_id',
        'user_id',
        'type',
        'old_value',
        'new_value',
        'note',
    ];

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
