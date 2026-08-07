<?php

namespace App\Support;

/**
 * Registry of togglable feature modules. Adding a new one here is the only
 * step required to make it controllable from Super Admin's Agency screen —
 * wrap its routes in the `feature:{key}` middleware and its nav links in
 * Agency::hasFeature($key), and the toggle infrastructure (override table,
 * middleware, admin UI) is already there to support it.
 */
class Feature
{
    const SALARY_COMMISSION = 'salary_commission';

    /**
     * @return array<string, array{label: string, description: string, default_enabled: bool}>
     */
    public static function all(): array
    {
        return [
            self::SALARY_COMMISSION => [
                'label' => 'Salary & Commission',
                'description' => 'Bookings, payments, compensation plans, commissions, payroll runs, and agent advances.',
                'default_enabled' => false,
            ],
        ];
    }

    public static function label(string $key): string
    {
        return self::all()[$key]['label'] ?? $key;
    }

    public static function defaultEnabled(string $key): bool
    {
        return self::all()[$key]['default_enabled'] ?? false;
    }
}
