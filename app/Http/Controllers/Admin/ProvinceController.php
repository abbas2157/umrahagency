<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Country;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProvinceController extends Controller
{
    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('admin.locations.provinces.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $province = Province::create($validated);

        ActivityLog::record('province_created', "Province '{$province->name}' created", null, 'Province', $province->id);

        return redirect()->route('admin.locations.index')->with('success', 'Province created.');
    }

    public function edit(Province $province)
    {
        $countries = Country::orderBy('name')->get();

        return view('admin.locations.provinces.edit', compact('province', 'countries'));
    }

    public function update(Request $request, Province $province)
    {
        $validated = $this->validated($request, $province);

        $province->update($validated);

        ActivityLog::record('province_updated', "Province '{$province->name}' updated", null, 'Province', $province->id);

        return redirect()->route('admin.locations.index')->with('success', 'Province updated.');
    }

    private function validated(Request $request, ?Province $province = null): array
    {
        $validated = $request->validate([
            'country_id' => ['required', 'exists:countries,id'],
            'name' => ['required', 'string', 'max:255', Rule::unique('provinces', 'name')->where('country_id', $request->input('country_id'))->ignore($province)],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
