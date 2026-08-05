<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::withCount([
            'inquiries',
            'users as agents_count' => fn ($query) => $query->where('role', 'agent'),
        ])->latest()->paginate(20);

        return view('admin.agencies.index', compact('agencies'));
    }

    public function create()
    {
        return view('admin.agencies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(array_merge($this->rules(), [
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['required', 'confirmed', 'min:8'],
        ]));

        $validated['is_active'] = $request->boolean('is_active');

        $adminName = $validated['admin_name'];
        $adminEmail = $validated['admin_email'];
        $adminPassword = $validated['admin_password'];
        unset($validated['admin_name'], $validated['admin_email'], $validated['admin_password']);

        // An agency can never exist with no one able to log into it — its
        // first Agency Admin is created in the same transaction, not as a
        // separate optional step.
        DB::transaction(function () use ($validated, $adminName, $adminEmail, $adminPassword) {
            $agency = Agency::create($validated);

            User::create([
                'name' => $adminName,
                'email' => $adminEmail,
                'password' => $adminPassword,
                'role' => 'agency_admin',
                'agency_id' => $agency->id,
            ]);

            ActivityLog::record('agency_created', "Agency '{$agency->name}' created", $agency->id, 'Agency', $agency->id);
        });

        return redirect()->route('admin.agencies.index')->with('success', 'Agency created, with '.$adminName.' as its Agency Admin login.');
    }

    public function edit(Agency $agency)
    {
        return view('admin.agencies.edit', compact('agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $validated = $request->validate($this->rules($agency));

        $validated['is_active'] = $request->boolean('is_active');
        $wasActive = $agency->is_active;

        $agency->update($validated);

        if ($wasActive !== $agency->is_active) {
            ActivityLog::record(
                $agency->is_active ? 'agency_activated' : 'agency_deactivated',
                "Agency '{$agency->name}' ".($agency->is_active ? 'activated' : 'deactivated'),
                $agency->id,
                'Agency',
                $agency->id
            );
        } else {
            ActivityLog::record('agency_updated', "Agency '{$agency->name}' updated", $agency->id, 'Agency', $agency->id);
        }

        return redirect()->route('admin.agencies.index')->with('success', 'Agency updated.');
    }

    private function rules(?Agency $agency = null): array
    {
        $slugUnique = 'unique:agencies,slug'.($agency ? ','.$agency->id : '');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', $slugUnique],
            'is_active' => ['sometimes', 'boolean'],

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
