<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AgentCompensation;
use App\Models\CompensationPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CompensationPlanController extends Controller
{
    const TYPES = ['salary', 'commission', 'salary_commission'];

    const COMMISSION_TYPES = ['percent_sale', 'percent_margin', 'fixed_per_tier'];

    public function index()
    {
        $plans = $this->ownPlans()->withCount('assignments')->orderByDesc('is_active')->orderBy('name')->get();

        $agents = User::where('agency_id', auth()->user()->agency_id)->where('role', 'agent')->active()
            ->with(['compensationHistory' => fn ($q) => $q->latest('effective_from')->limit(1), 'compensationHistory.plan'])
            ->orderBy('name')->get();

        return view('agency.compensation-plans.index', compact('plans', 'agents'));
    }

    public function create()
    {
        return view('agency.compensation-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePlan($request);
        $validated['agency_id'] = auth()->user()->agency_id;
        $validated['is_active'] = true;

        $plan = CompensationPlan::create($validated);

        ActivityLog::record('compensation_plan_created', "Compensation plan '{$plan->name}' created", $plan->agency_id, 'CompensationPlan', $plan->id);

        return redirect()->route('agency.compensation-plans.index')->with('success', 'Compensation plan created.');
    }

    public function edit(CompensationPlan $compensationPlan)
    {
        $this->authorizeOwnPlan($compensationPlan);

        return view('agency.compensation-plans.edit', ['plan' => $compensationPlan]);
    }

    public function update(Request $request, CompensationPlan $compensationPlan)
    {
        $this->authorizeOwnPlan($compensationPlan);

        $validated = $this->validatePlan($request);

        $compensationPlan->update($validated);

        ActivityLog::record('compensation_plan_updated', "Compensation plan '{$compensationPlan->name}' updated", $compensationPlan->agency_id, 'CompensationPlan', $compensationPlan->id);

        return redirect()->route('agency.compensation-plans.index')->with('success', 'Compensation plan updated.');
    }

    /**
     * Deactivating a plan stops it being offered for new assignments but
     * never touches agents already on it — their AgentCompensation row is
     * untouched, same "deactivate never delete" rule as everywhere else.
     */
    public function deactivate(CompensationPlan $compensationPlan)
    {
        $this->authorizeOwnPlan($compensationPlan);

        $compensationPlan->update(['is_active' => false]);

        ActivityLog::record('compensation_plan_deactivated', "Compensation plan '{$compensationPlan->name}' deactivated", $compensationPlan->agency_id, 'CompensationPlan', $compensationPlan->id);

        return back()->with('success', 'Compensation plan deactivated.');
    }

    public function activate(CompensationPlan $compensationPlan)
    {
        $this->authorizeOwnPlan($compensationPlan);

        $compensationPlan->update(['is_active' => true]);

        ActivityLog::record('compensation_plan_activated', "Compensation plan '{$compensationPlan->name}' activated", $compensationPlan->agency_id, 'CompensationPlan', $compensationPlan->id);

        return back()->with('success', 'Compensation plan activated.');
    }

    /**
     * Assigns a plan to an agent as of a given date. Rate changes are never
     * retroactive: the agent's currently open-ended assignment (if any) is
     * closed off the day before the new one starts, it's never edited or
     * backdated over.
     */
    public function assign(Request $request, User $agent)
    {
        abort_unless($agent->agency_id === auth()->user()->agency_id && $agent->role === 'agent', 404);

        $validated = $request->validate([
            'plan_id' => ['required', Rule::exists('compensation_plans', 'id')->where('agency_id', auth()->user()->agency_id)->where('is_active', true)],
            'effective_from' => ['required', 'date'],
        ]);

        $effectiveFrom = Carbon::parse($validated['effective_from']);

        DB::transaction(function () use ($agent, $validated, $effectiveFrom) {
            AgentCompensation::where('agent_id', $agent->id)
                ->whereNull('effective_to')
                ->where('effective_from', '<', $effectiveFrom)
                ->update(['effective_to' => $effectiveFrom->copy()->subDay()]);

            AgentCompensation::create([
                'agency_id' => auth()->user()->agency_id,
                'agent_id' => $agent->id,
                'plan_id' => $validated['plan_id'],
                'effective_from' => $effectiveFrom,
            ]);
        });

        $plan = CompensationPlan::find($validated['plan_id']);

        ActivityLog::record('compensation_plan_assigned', "'{$plan->name}' assigned to agent '{$agent->name}'", $agent->agency_id, 'User', $agent->id);

        return back()->with('success', 'Compensation plan assigned.');
    }

    private function ownPlans()
    {
        return CompensationPlan::where('agency_id', auth()->user()->agency_id);
    }

    private function authorizeOwnPlan(CompensationPlan $plan): void
    {
        abort_unless($plan->agency_id === auth()->user()->agency_id, 404);
    }

    private function validatePlan(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(self::TYPES)],
            'base_salary' => ['required_if:type,salary,salary_commission', 'nullable', 'numeric', 'min:0'],
            'commission_type' => ['required_if:type,commission,salary_commission', 'nullable', Rule::in(self::COMMISSION_TYPES)],
            'commission_rate' => ['required_if:commission_type,percent_sale,percent_margin', 'nullable', 'numeric', 'min:0', 'max:100'],
            'tier_rates' => ['required_if:commission_type,fixed_per_tier', 'nullable', 'array'],
            'tier_rates.*' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['base_salary'] = $validated['base_salary'] ?? 0;

        if ($validated['type'] === 'salary') {
            $validated['commission_type'] = null;
            $validated['commission_rate'] = null;
            $validated['tier_rates'] = null;
        } elseif ($validated['commission_type'] !== 'fixed_per_tier') {
            $validated['tier_rates'] = null;
        } else {
            $validated['commission_rate'] = null;
            $validated['tier_rates'] = array_filter($validated['tier_rates'] ?? [], fn ($v) => $v !== null && $v !== '');
        }

        return $validated;
    }
}
