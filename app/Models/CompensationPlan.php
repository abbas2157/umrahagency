<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompensationPlan extends Model
{
    protected $fillable = [
        'agency_id',
        'name',
        'type',
        'base_salary',
        'commission_type',
        'commission_rate',
        'tier_rates',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'base_salary' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'tier_rates' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AgentCompensation::class, 'plan_id');
    }
}
