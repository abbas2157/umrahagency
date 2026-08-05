<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedSuperAdmin();
        $this->seedLocations();

        if (App::environment('local')) {
            $this->seedLocalTestAccounts();
        }
    }

    /**
     * Reads credentials from the environment rather than hardcoding them,
     * so a real login never sits in the repo as committed placeholder text.
     */
    private function seedSuperAdmin(): void
    {
        $email = env('SUPER_ADMIN_EMAIL');
        $password = env('SUPER_ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command->warn('SUPER_ADMIN_EMAIL / SUPER_ADMIN_PASSWORD not set in .env — skipping Super Admin seed.');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => $password,
                'role' => 'super_admin',
                'agency_id' => null,
            ]
        );
    }

    /**
     * Pakistan + its real provinces — factual reference data, not test
     * fixtures. Phase 1 is Pakistan-only per the product plan. Cities and
     * areas are deliberately not seeded — those depend on actual agency
     * coverage, which isn't ours to guess.
     */
    private function seedLocations(): void
    {
        $pakistan = Country::firstOrCreate(
            ['iso2' => 'PK'],
            ['name' => 'Pakistan', 'is_active' => true]
        );

        foreach ([
            'Punjab',
            'Sindh',
            'Khyber Pakhtunkhwa',
            'Balochistan',
            'Gilgit-Baltistan',
            'Azad Jammu and Kashmir',
            'Islamabad Capital Territory',
        ] as $province) {
            $pakistan->provinces()->firstOrCreate(['name' => $province], ['is_active' => true]);
        }
    }

    private function seedLocalTestAccounts(): void
    {
        $agency = Agency::firstOrCreate(
            ['slug' => 'test-agency'],
            ['name' => 'Test Agency', 'is_active' => true]
        );

        User::updateOrCreate(
            ['email' => 'agency-admin@example.test'],
            [
                'name' => 'Test Agency Admin',
                'password' => 'password',
                'role' => 'agency_admin',
                'agency_id' => $agency->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'agent@example.test'],
            [
                'name' => 'Test Agent',
                'password' => 'password',
                'role' => 'agent',
                'agency_id' => $agency->id,
            ]
        );
    }
}
