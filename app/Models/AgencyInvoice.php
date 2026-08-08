<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyInvoice extends Model
{
    protected $fillable = [
        'agency_id',
        'plan_id',
        'plan_name_snapshot',
        'amount',
        'period_start',
        'period_end',
        'status',
        'paid_at',
        'payment_method',
        'payment_reference',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'period_start' => 'date',
            'period_end' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Computed, not stored — an invoice becomes overdue simply by its due
     * date passing while unpaid. No scheduled job needed to flip a status
     * column; this just reflects reality whenever it's checked.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending' && $this->period_end->isPast();
    }
}
