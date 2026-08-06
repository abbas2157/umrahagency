<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Support\UserAgentParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mirrors the DB column default. Without this, a User::create() that
     * doesn't pass is_active explicitly leaves the in-memory model without
     * that attribute at all (Eloquent doesn't re-fetch DB-generated
     * defaults after an insert) — so ->is_active reads as null, not true,
     * on that same object until it's refreshed from the database.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'agency_id',
        'branch_id',
        'designation',
        'phone',
        'whatsapp',
        'languages',
        'specialization',
        'photo',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(AgencyBranch::class, 'branch_id');
    }

    /**
     * Performance snapshot for an agent: volume, outcome mix, and average
     * time to first response. "First response" is the first status_change
     * activity moving an inquiry off 'new' — the earliest observable sign
     * the agent actually worked the lead, not just that it landed on them.
     *
     * @return array{total: int, booked: int, lost: int, open: int, conversion_rate: int, avg_response_minutes: ?int}
     */
    public function performanceStats(): array
    {
        $inquiries = Inquiry::where('assigned_agent_id', $this->id)->get(['id', 'status', 'assigned_at']);

        $total = $inquiries->count();
        $booked = $inquiries->where('status', 'booked')->count();
        $lost = $inquiries->whereIn('status', ['lost', 'junk'])->count();

        $firstResponses = InquiryActivity::whereIn('inquiry_id', $inquiries->pluck('id'))
            ->where('type', 'status_change')
            ->where('old_value', 'new')
            ->orderBy('created_at')
            ->get()
            ->unique('inquiry_id')
            ->keyBy('inquiry_id');

        $responseMinutes = $inquiries
            ->filter(fn (Inquiry $inquiry) => $inquiry->assigned_at && $firstResponses->has($inquiry->id))
            ->map(fn (Inquiry $inquiry) => $inquiry->assigned_at->diffInMinutes($firstResponses[$inquiry->id]->created_at));

        return [
            'total' => $total,
            'booked' => $booked,
            'lost' => $lost,
            'open' => $total - $booked - $lost,
            'conversion_rate' => $total > 0 ? (int) round(($booked / $total) * 100) : 0,
            'avg_response_minutes' => $responseMinutes->isNotEmpty() ? (int) round($responseMinutes->avg()) : null,
        ];
    }

    /**
     * Human-readable form of performanceStats()'s avg_response_minutes,
     * shared by every screen that displays it.
     */
    public static function formatResponseMinutes(?int $minutes): string
    {
        if ($minutes === null) {
            return '—';
        }

        if ($minutes < 60) {
            return $minutes.'m';
        }

        if ($minutes < 1440) {
            return round($minutes / 60, 1).'h';
        }

        return round($minutes / 1440, 1).'d';
    }

    /**
     * Stores an uploaded agent photo under the public disk and returns the
     * URL to save into `photo`. Mirrors Agency::storeLogoUpload — deletes
     * the previous file only if it was itself a local upload, never an
     * externally hosted link.
     */
    public static function storePhotoUpload(UploadedFile $file, ?string $previousPath = null): string
    {
        if ($previousPath && str_starts_with($previousPath, '/storage/')) {
            Storage::disk('public')->delete(substr($previousPath, strlen('/storage/')));
        }

        return '/storage/'.$file->store('agents/photos', 'public');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAgencyAdmin(): bool
    {
        return $this->role === 'agency_admin';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Active login sessions for this user, newest-active first. Shared by
     * every screen that lists devices (My Account, Super Admin's Users,
     * Agency Admin's Agents) so the listing logic exists in one place.
     *
     * @return \Illuminate\Support\Collection<int, array{id: string, device: string, ip_address: ?string, last_active: \Illuminate\Support\Carbon, is_current: bool}>
     */
    public function activeSessions(?string $currentSessionId = null)
    {
        return DB::table('sessions')
            ->where('user_id', $this->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(fn ($session) => [
                'id' => $session->id,
                'device' => UserAgentParser::describe($session->user_agent),
                'ip_address' => $session->ip_address,
                'last_active' => now()->setTimestamp($session->last_activity),
                'is_current' => $session->id === $currentSessionId,
            ]);
    }
}

