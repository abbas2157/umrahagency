<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agency;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgencyProfileController extends Controller
{
    public function edit(Request $request)
    {
        $agency = $request->user()->agency;

        abort_if(! $agency, 404);

        $cities = City::where('is_active', true)->with('province')->orderBy('name')->get();

        return view('agency.agency-profile.edit', compact('agency', 'cities'));
    }

    public function update(Request $request)
    {
        $agency = $request->user()->agency;

        abort_if(! $agency, 404);

        $validated = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('agencies', 'slug')->ignore($agency)],
            'cities' => ['nullable', 'array'],
            'cities.*' => ['exists:cities,id'],
            'logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], Agency::businessProfileRules()));

        $cityIds = $validated['cities'] ?? [];
        unset($validated['cities']);

        if ($request->hasFile('logo_file')) {
            $validated['logo_path'] = Agency::storeLogoUpload($request->file('logo_file'), $agency->logo_path);
        }
        unset($validated['logo_file']);

        $agency->update($validated);
        $agency->cities()->sync($cityIds);

        ActivityLog::record('agency_updated', "Agency '{$agency->name}' updated", $agency->id, 'Agency', $agency->id);

        return redirect()->route('agency.agency-profile.edit')->with('success', 'Agency profile updated.');
    }
}
