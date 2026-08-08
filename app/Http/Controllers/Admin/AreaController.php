<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AreaController extends Controller
{
    public function create()
    {
        $cities = City::with('province.country')->orderBy('name')->get();

        return view('admin.locations.areas.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $area = Area::create($validated);

        ActivityLog::record('area_created', "Area '{$area->name}' created", null, 'Area', $area->id);

        return redirect()->route('admin.locations.index')->with('success', 'Area created.');
    }

    public function edit(Area $area)
    {
        $cities = City::with('province.country')->orderBy('name')->get();

        return view('admin.locations.areas.edit', compact('area', 'cities'));
    }

    public function update(Request $request, Area $area)
    {
        $validated = $this->validated($request, $area);

        $area->update($validated);

        ActivityLog::record('area_updated', "Area '{$area->name}' updated", null, 'Area', $area->id);

        return redirect()->route('admin.locations.index')->with('success', 'Area updated.');
    }

    private function validated(Request $request, ?Area $area = null): array
    {
        $validated = $request->validate([
            'city_id' => ['required', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:255', Rule::unique('areas', 'name')->where('city_id', $request->input('city_id'))->ignore($area)],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
