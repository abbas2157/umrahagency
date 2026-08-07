<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agency;
use App\Models\AgencyFeatureOverride;
use App\Support\Feature;
use Illuminate\Http\Request;

class AgencyFeatureController extends Controller
{
    /**
     * Toggles a feature on or off for one agency. $featureKey is validated
     * against the registry, not a free-form string — only features a
     * developer has actually wired up can ever be toggled.
     */
    public function update(Request $request, Agency $agency, string $featureKey)
    {
        abort_unless(array_key_exists($featureKey, Feature::all()), 404);

        $validated = $request->validate([
            'is_enabled' => ['required', 'boolean'],
        ]);

        AgencyFeatureOverride::updateOrCreate(
            ['agency_id' => $agency->id, 'feature_key' => $featureKey],
            ['is_enabled' => $validated['is_enabled'], 'set_by' => auth()->id()]
        );

        $label = Feature::label($featureKey);
        $state = $validated['is_enabled'] ? 'enabled' : 'disabled';

        ActivityLog::record("feature_{$state}", "'{$label}' {$state} for agency '{$agency->name}'", $agency->id, 'Agency', $agency->id);

        return back()->with('success', "{$label} {$state}.");
    }

    /**
     * Removes the override so the agency falls back to the feature's coded
     * default — for undoing a one-off toggle rather than pinning a value.
     */
    public function reset(Agency $agency, string $featureKey)
    {
        abort_unless(array_key_exists($featureKey, Feature::all()), 404);

        AgencyFeatureOverride::where('agency_id', $agency->id)->where('feature_key', $featureKey)->delete();

        $label = Feature::label($featureKey);

        ActivityLog::record('feature_reset', "'{$label}' reset to default for agency '{$agency->name}'", $agency->id, 'Agency', $agency->id);

        return back()->with('success', "{$label} reset to default.");
    }
}
