<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Inquiry extends Model
{
    const STATUSES = ['new', 'contacted', 'quoted', 'booked', 'lost', 'junk'];

    const LOST_REASONS = [
        'Price too high',
        'Booked with another agency',
        'Dates changed',
        'Not reachable after multiple attempts',
        'Just browsing',
        'Budget not ready',
        'Wanted unavailable hotel',
        'Visa concern',
        'Other',
    ];

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
        'agency_id',
        'assigned_agent_id',
        'status',
        'lost_reason',
        'assigned_at',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        // Agency Admins only see their own agency's queries; Agents only see
        // the ones assigned to them. Scoped here, once, so no controller can
        // forget the filter and leak one agency's queries to another.
        static::addGlobalScope('visibleToRole', function (Builder $query) {
            $user = Auth::user();

            if (! $user || $user->isSuperAdmin()) {
                return;
            }

            if ($user->isAgent()) {
                $query->where('assigned_agent_id', $user->id);

                return;
            }

            $query->where('agency_id', $user->agency_id);
        });
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(InquiryActivity::class);
    }

    /**
     * "Stuck" queries: still open (not booked/lost/junk) and nothing has
     * touched their status in $days. updated_at is a reliable proxy for
     * "last status change" here — status/assignment are the only fields
     * that ever get updated via ->update() on this model; notes go through
     * InquiryActivity instead and don't bump it.
     */
    public function scopeNeedsFollowUp(Builder $query, int $days = 3): Builder
    {
        return $query->whereNotIn('status', ['booked', 'lost', 'junk'])
            ->where('updated_at', '<=', now()->subDays($days));
    }
}
