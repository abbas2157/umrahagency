<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgencyBranch extends Model
{
    protected $fillable = [
        'agency_id',
        'name',
        'is_main',
        'is_active',
        'address_line',
        'area',
        'city_id',
        'latitude',
        'longitude',
        'phone',
        'whatsapp',
        'email',
        'hours',
        'maps_url',
    ];

    protected function casts(): array
    {
        return [
            'is_main' => 'boolean',
            'is_active' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
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

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Staff (role: agent) who work out of this branch — distinct from the
     * agency-wide Agents roster, which every agent belongs to regardless of
     * branch assignment.
     */
    public function agents(): HasMany
    {
        return $this->hasMany(User::class, 'branch_id')->where('role', 'agent');
    }
}
