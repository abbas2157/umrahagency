<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function create()
    {
        return view('admin.locations.countries.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $country = Country::create($validated);

        ActivityLog::record('country_created', "Country '{$country->name}' created", null, 'Country', $country->id);

        return redirect()->route('admin.locations.index')->with('success', 'Country created.');
    }

    public function edit(Country $country)
    {
        return view('admin.locations.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $this->validated($request, $country);

        $country->update($validated);

        ActivityLog::record('country_updated', "Country '{$country->name}' updated", null, 'Country', $country->id);

        return redirect()->route('admin.locations.index')->with('success', 'Country updated.');
    }

    private function validated(Request $request, ?Country $country = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('countries', 'name')->ignore($country)],
            'iso2' => ['nullable', 'string', 'size:2', Rule::unique('countries', 'iso2')->ignore($country)],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['iso2'] = $validated['iso2'] ? strtoupper($validated['iso2']) : null;

        return $validated;
    }
}
