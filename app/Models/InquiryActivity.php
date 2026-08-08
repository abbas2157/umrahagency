<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Records an activity on an inquiry. Shared between the Admin and
     * Agency inquiry controllers now that they're separate classes in
     * separate modules.
     */
    public static function record(Inquiry $inquiry, string $type, ?string $old, ?string $new, ?string $note): self
    {
        return static::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => Auth::id(),
            'type' => $type,
            'old_value' => $old,
            'new_value' => $new,
            'note' => $note,
        ]);
    }

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
