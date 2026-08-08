<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::withCount('agencies')->orderBy('price')->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePlan($request);
        $validated['is_active'] = true;

        $plan = Plan::create($validated);

        ActivityLog::record('plan_created', "Plan '{$plan->name}' created", null, 'Plan', $plan->id);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created.');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $this->validatePlan($request, $plan);

        $plan->update($validated);

        ActivityLog::record('plan_updated', "Plan '{$plan->name}' updated", null, 'Plan', $plan->id);

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated.');
    }

    /**
     * Never hard-deleted — past invoices keep a plan_name_snapshot, but
     * still reference plan_id for filtering, and agencies currently
     * subscribed to it would otherwise lose that link.
     */
    public function deactivate(Plan $plan)
    {
        $plan->update(['is_active' => false]);

        ActivityLog::record('plan_deactivated', "Plan '{$plan->name}' deactivated", null, 'Plan', $plan->id);

        return redirect()->route('admin.plans.index')->with('success', 'Plan deactivated — existing subscribers are unaffected, but it can no longer be assigned to new agencies.');
    }

    public function activate(Plan $plan)
    {
        $plan->update(['is_active' => true]);

        ActivityLog::record('plan_activated', "Plan '{$plan->name}' activated", null, 'Plan', $plan->id);

        return redirect()->route('admin.plans.index')->with('success', 'Plan activated.');
    }

    private function validatePlan(Request $request, ?Plan $plan = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('plans', 'slug')->ignore($plan)],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'billing_cycle' => ['required', Rule::in(['monthly', 'yearly'])],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);
    }
}
