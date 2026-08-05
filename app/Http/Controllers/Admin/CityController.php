<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function create()
    {
        $provinces = Province::with('country')->orderBy('name')->get();

        return view('admin.locations.cities.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $city = City::create($validated);

        ActivityLog::record('city_created', "City '{$city->name}' created", null, 'City', $city->id);

        return redirect()->route('admin.locations.index')->with('success', 'City created.');
    }

    public function edit(City $city)
    {
        $provinces = Province::with('country')->orderBy('name')->get();

        return view('admin.locations.cities.edit', compact('city', 'provinces'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $this->validated($request, $city);

        $city->update($validated);

        ActivityLog::record('city_updated', "City '{$city->name}' updated", null, 'City', $city->id);

        return redirect()->route('admin.locations.index')->with('success', 'City updated.');
    }

    private function validated(Request $request, ?City $city = null): array
    {
        $validated = $request->validate([
            'province_id' => ['required', 'exists:provinces,id'],
            'name' => ['required', 'string', 'max:255', Rule::unique('cities', 'name')->where('province_id', $request->input('province_id'))->ignore($city)],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
