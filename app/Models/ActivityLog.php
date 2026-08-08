<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'actor_id',
        'agency_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'ip_address',
    ];

    /**
     * Records a system-wide event. $agencyId should be the affected
     * subject's agency (e.g. the user being edited), not necessarily the
     * actor's own — that's what lets an Agency Admin see what happened to
     * their own agency and their own agents, even when Super Admin was the
     * one who made the change.
     */
    public static function record(string $action, string $description, ?int $agencyId = null, ?string $subjectType = null, ?int $subjectId = null): self
    {
        return static::create([
            'actor_id' => Auth::id(),
            'agency_id' => $agencyId,
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'description' => $description,
            'ip_address' => Request::ip(),
        ]);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }
}
