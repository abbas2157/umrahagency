<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'agency_id',
        'inquiry_id',
        'agent_id',
        'package_tier',
        'total_price',
        'cost_price',
        'status',
        'booked_at',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'booked_at' => 'date',
        ];
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function totalReceived(): string
    {
        return (string) $this->payments()->where('status', 'received')->sum('amount');
    }
}
