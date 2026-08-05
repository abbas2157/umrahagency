<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',

        // Identity
        'legal_name',
        'founded_year',
        'owner_name',
        'tagline',
        'logo_path',

        // Phone & messaging
        'phone_local',
        'phone_e164',
        'whatsapp',
        'phone_secondary',
        'landline',
        'best_hours_to_call',

        // Email
        'email_general',
        'email_bookings',
        'email_support',

        // Address
        'address_line',
        'address_area',
        'city',
        'province',
        'postal_code',
        'country',
        'maps_url',
        'latitude',
        'longitude',
        'branch_offices',

        // Opening hours
        'hours_mon_thu',
        'hours_friday',
        'hours_saturday',
        'hours_sunday',
        'hours_public_holidays',
        'timezone',

        // Licensing & trust signals
        'mora_license_no',
        'dts_license_no',
        'iata_no',
        'ntn',
        'memberships',
        'nusuk_registration',

        // Social profiles
        'social_facebook',
        'social_twitter',
        'social_instagram',
        'social_pinterest',
        'social_youtube',
        'social_tiktok',
        'social_google_business',

        // Service & operations
        'departure_airports',
        'services_offered',
        'languages_spoken',
        'currency',
        'payment_methods',
        'deposit_policy',
        'refund_policy_url',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }
}
