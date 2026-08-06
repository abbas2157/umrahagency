<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Agency extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'plan_id',

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

    /**
     * Cities this agency serves — the basis for auto-routing a new query
     * to an agency by matching its departure_airport to a city name.
     */
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'agency_cities');
    }

    /**
     * Physical branch offices/outlets — distinct from cities(), which is
     * routing eligibility, not a real address.
     */
    public function branches(): HasMany
    {
        return $this->hasMany(AgencyBranch::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(AgencyInvoice::class)->latest('period_start');
    }

    /**
     * Field groups mirroring the profile-form sections (admin/agencies/_form.blade.php)
     * one-for-one, so a section's completion state and the overall percentage
     * can be computed without duplicating this list in the view.
     */
    public static function profileFieldGroups(): array
    {
        return [
            'identity' => ['legal_name', 'founded_year', 'owner_name', 'tagline', 'logo_path'],
            'phone' => ['phone_local', 'phone_e164', 'whatsapp', 'phone_secondary', 'landline', 'best_hours_to_call'],
            'email' => ['email_general', 'email_bookings', 'email_support'],
            'address' => ['address_line', 'address_area', 'city', 'province', 'postal_code', 'country', 'maps_url', 'latitude', 'longitude', 'branch_offices'],
            'hours' => ['hours_mon_thu', 'hours_friday', 'hours_saturday', 'hours_sunday', 'hours_public_holidays', 'timezone'],
            'licensing' => ['mora_license_no', 'dts_license_no', 'iata_no', 'ntn', 'memberships', 'nusuk_registration'],
            'social' => ['social_facebook', 'social_twitter', 'social_instagram', 'social_pinterest', 'social_youtube', 'social_tiktok', 'social_google_business'],
            'service' => ['departure_airports', 'services_offered', 'languages_spoken', 'currency', 'payment_methods', 'deposit_policy', 'refund_policy_url'],
        ];
    }

    /**
     * 0–1 fill ratio for one profile section. Coverage has no scalar fields —
     * it's "complete" once at least one city is attached — so it's handled
     * separately from the flat field-group list above.
     */
    public function sectionCompletionRatio(string $section): float
    {
        if ($section === 'coverage') {
            return $this->cities()->exists() ? 1.0 : 0.0;
        }

        $fields = static::profileFieldGroups()[$section] ?? [];

        if (empty($fields)) {
            return 1.0;
        }

        $filled = collect($fields)->filter(fn ($field) => filled($this->{$field}))->count();

        return $filled / count($fields);
    }

    public function isSectionComplete(string $section): bool
    {
        return $this->sectionCompletionRatio($section) >= 1.0;
    }

    /**
     * Overall profile completeness, averaged across sections (not fields) so
     * Coverage — a single yes/no — carries the same weight as Address's ten
     * fields, matching how the step wizard presents them to the user.
     */
    public function completionPercentage(): int
    {
        $sections = [...array_keys(static::profileFieldGroups()), 'coverage'];

        $total = collect($sections)->sum(fn ($section) => $this->sectionCompletionRatio($section));

        return (int) round(($total / count($sections)) * 100);
    }

    /**
     * Stores an uploaded logo under the public disk and returns the URL to
     * save into logo_path. Deletes the previous file first, but only if it
     * was itself a locally-stored upload — never touches an externally
     * hosted link left in the same column.
     */
    public static function storeLogoUpload(UploadedFile $file, ?string $previousPath = null): string
    {
        if ($previousPath && str_starts_with($previousPath, '/storage/')) {
            Storage::disk('public')->delete(substr($previousPath, strlen('/storage/')));
        }

        return '/storage/'.$file->store('agencies/logos', 'public');
    }

    /**
     * Validation rules for every business-profile field — everything except
     * name/slug/is_active, which differ between a full Super Admin edit and
     * an Agency Admin editing their own profile (no is_active, can't touch
     * their own suspension state).
     */
    public static function businessProfileRules(): array
    {
        return [
            'legal_name' => ['nullable', 'string', 'max:255'],
            'founded_year' => ['nullable', 'string', 'max:10'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'logo_path' => ['nullable', 'string', 'max:255'],

            'phone_local' => ['nullable', 'string', 'max:50'],
            'phone_e164' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'phone_secondary' => ['nullable', 'string', 'max:50'],
            'landline' => ['nullable', 'string', 'max:50'],
            'best_hours_to_call' => ['nullable', 'string', 'max:255'],

            'email_general' => ['nullable', 'email', 'max:255'],
            'email_bookings' => ['nullable', 'email', 'max:255'],
            'email_support' => ['nullable', 'email', 'max:255'],

            'address_line' => ['nullable', 'string', 'max:255'],
            'address_area' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
            'maps_url' => ['nullable', 'url', 'max:2048'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'branch_offices' => ['nullable', 'string'],

            'hours_mon_thu' => ['nullable', 'string', 'max:255'],
            'hours_friday' => ['nullable', 'string', 'max:255'],
            'hours_saturday' => ['nullable', 'string', 'max:255'],
            'hours_sunday' => ['nullable', 'string', 'max:255'],
            'hours_public_holidays' => ['nullable', 'string', 'max:255'],
            'timezone' => ['nullable', 'string', 'max:100'],

            'mora_license_no' => ['nullable', 'string', 'max:255'],
            'dts_license_no' => ['nullable', 'string', 'max:255'],
            'iata_no' => ['nullable', 'string', 'max:255'],
            'ntn' => ['nullable', 'string', 'max:255'],
            'memberships' => ['nullable', 'string', 'max:255'],
            'nusuk_registration' => ['nullable', 'string', 'max:255'],

            'social_facebook' => ['nullable', 'url', 'max:2048'],
            'social_twitter' => ['nullable', 'url', 'max:2048'],
            'social_instagram' => ['nullable', 'url', 'max:2048'],
            'social_pinterest' => ['nullable', 'url', 'max:2048'],
            'social_youtube' => ['nullable', 'url', 'max:2048'],
            'social_tiktok' => ['nullable', 'url', 'max:2048'],
            'social_google_business' => ['nullable', 'url', 'max:2048'],

            'departure_airports' => ['nullable', 'string'],
            'services_offered' => ['nullable', 'string'],
            'languages_spoken' => ['nullable', 'string', 'max:255'],
            'currency' => ['nullable', 'string', 'max:10'],
            'payment_methods' => ['nullable', 'string', 'max:255'],
            'deposit_policy' => ['nullable', 'string'],
            'refund_policy_url' => ['nullable', 'string', 'max:255'],
        ];
    }
}
