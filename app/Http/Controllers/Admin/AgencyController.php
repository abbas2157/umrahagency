<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agency;
use App\Models\City;
use App\Models\Plan;
use App\Models\User;
use App\Support\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::withCount([
            'inquiries',
            'branches',
            'users as agents_count' => fn ($query) => $query->where('role', 'agent'),
        ])->latest()->paginate(20);

        return view('admin.agencies.index', compact('agencies'));
    }

    /**
     * Read-only oversight — Super Admin can see everything an agency has
     * built (branches, agent roster, performance, coverage) but editing
     * agents/branches themselves stays the owning Agency Admin's job, same
     * boundary as the rest of the platform.
     */
    public function show(Agency $agency)
    {
        $branches = $agency->branches()->with('city.province')->orderByDesc('is_main')->orderBy('name')->get();

        $agents = $agency->users()->where('role', 'agent')->with('branch')->orderBy('name')->get()
            ->map(fn (User $agent) => ['agent' => $agent, ...$agent->performanceStats()]);

        $coverageCities = $agency->cities()->with('province')->orderBy('name')->get();

        $invoices = $agency->invoices()->with('plan')->get();
        $plans = Plan::active()->orderBy('price')->get();

        $features = Feature::all();
        $featureOverrides = $agency->featureOverrides->keyBy('feature_key');

        return view('admin.agencies.show', compact('agency', 'branches', 'agents', 'coverageCities', 'invoices', 'plans', 'features', 'featureOverrides'));
    }

    public function create()
    {
        $cities = City::where('is_active', true)->with('province')->orderBy('name')->get();

        return view('admin.agencies.create', compact('cities'));
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
        $cityIds = $validated['cities'] ?? [];
        unset($validated['admin_name'], $validated['admin_email'], $validated['admin_password'], $validated['cities']);

        if ($request->hasFile('logo_file')) {
            $validated['logo_path'] = Agency::storeLogoUpload($request->file('logo_file'));
        }
        unset($validated['logo_file']);

        // An agency can never exist with no one able to log into it — its
        // first Agency Admin is created in the same transaction, not as a
        // separate optional step.
        DB::transaction(function () use ($validated, $adminName, $adminEmail, $adminPassword, $cityIds) {
            $agency = Agency::create($validated);
            $agency->cities()->sync($cityIds);

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
        $cities = City::where('is_active', true)->with('province')->orderBy('name')->get();

        return view('admin.agencies.edit', compact('agency', 'cities'));
    }

    public function update(Request $request, Agency $agency)
    {
        $validated = $request->validate($this->rules($agency));

        $validated['is_active'] = $request->boolean('is_active');
        $cityIds = $validated['cities'] ?? [];
        unset($validated['cities']);
        $wasActive = $agency->is_active;

        if ($request->hasFile('logo_file')) {
            $validated['logo_path'] = Agency::storeLogoUpload($request->file('logo_file'), $agency->logo_path);
        }
        unset($validated['logo_file']);

        $agency->update($validated);
        $agency->cities()->sync($cityIds);

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

        return array_merge([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', $slugUnique],
            'is_active' => ['sometimes', 'boolean'],
            'cities' => ['nullable', 'array'],
            'cities.*' => ['exists:cities,id'],
            'logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], Agency::businessProfileRules());
    }
}
