<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AgencyBranch;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function index()
    {
        $branches = $this->ownBranches()->with(['city.province', 'agents'])->orderByDesc('is_main')->orderBy('name')->get();

        return view('agency.branches.index', compact('branches'));
    }

    public function create()
    {
        $cities = City::where('is_active', true)->with('province')->orderBy('name')->get();

        return view('agency.branches.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBranch($request);
        $validated['agency_id'] = auth()->user()->agency_id;
        $validated['is_active'] = true;

        $branch = DB::transaction(function () use ($validated) {
            if ($validated['is_main']) {
                $this->ownBranches()->update(['is_main' => false]);
            }

            return AgencyBranch::create($validated);
        });

        ActivityLog::record('branch_created', "Branch '{$branch->name}' created", $branch->agency_id, 'AgencyBranch', $branch->id);

        return redirect()->route('agency.branches.index')->with('success', 'Branch added.');
    }

    public function edit(AgencyBranch $branch)
    {
        $this->authorizeOwnBranch($branch);

        $cities = City::where('is_active', true)->with('province')->orderBy('name')->get();

        return view('agency.branches.edit', compact('branch', 'cities'));
    }

    public function update(Request $request, AgencyBranch $branch)
    {
        $this->authorizeOwnBranch($branch);

        $validated = $this->validateBranch($request);

        DB::transaction(function () use ($branch, $validated) {
            if ($validated['is_main']) {
                $this->ownBranches()->where('id', '!=', $branch->id)->update(['is_main' => false]);
            }

            $branch->update($validated);
        });

        ActivityLog::record('branch_updated', "Branch '{$branch->name}' updated", $branch->agency_id, 'AgencyBranch', $branch->id);

        return redirect()->route('agency.branches.index')->with('success', 'Branch updated.');
    }

    /**
     * Branches are never hard-deleted — they're referenced by past enquiries
     * and (potentially) staff history. Deactivating is also blocked while
     * agents still work out of the branch, so nobody's assignment silently
     * disappears; they must be reassigned first.
     */
    public function deactivate(AgencyBranch $branch)
    {
        $this->authorizeOwnBranch($branch);

        $agentCount = $branch->agents()->count();

        if ($agentCount > 0) {
            return back()->with('error', "Can't deactivate — {$agentCount} ".str('agent')->plural($agentCount)." still assigned to this branch. Reassign them first.");
        }

        $branch->update(['is_active' => false]);

        ActivityLog::record('branch_deactivated', "Branch '{$branch->name}' deactivated", $branch->agency_id, 'AgencyBranch', $branch->id);

        return redirect()->route('agency.branches.index')->with('success', 'Branch deactivated.');
    }

    public function activate(AgencyBranch $branch)
    {
        $this->authorizeOwnBranch($branch);

        $branch->update(['is_active' => true]);

        ActivityLog::record('branch_activated', "Branch '{$branch->name}' activated", $branch->agency_id, 'AgencyBranch', $branch->id);

        return redirect()->route('agency.branches.index')->with('success', 'Branch activated.');
    }

    /**
     * Scopes every query to the acting Agency Admin's own agency — Branch
     * has no global tenancy scope (unlike Inquiry), so it's enforced
     * explicitly at the controller boundary, same as Agents.
     */
    private function ownBranches()
    {
        return AgencyBranch::where('agency_id', auth()->user()->agency_id);
    }

    private function authorizeOwnBranch(AgencyBranch $branch): void
    {
        abort_unless($branch->agency_id === auth()->user()->agency_id, 404);
    }

    private function validateBranch(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address_line' => ['required', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'city_id' => ['required', 'exists:cities,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            // E.164 with a leading + — matches BRANCH-ENTITY.md's tel: link format.
            'phone' => ['required', 'regex:/^\+[1-9]\d{9,14}$/'],
            // Digits only, no + and no leading 0 — matches BRANCH-ENTITY.md's wa.me/ format.
            'whatsapp' => ['required', 'regex:/^[1-9]\d{10,14}$/'],
            'email' => ['required', 'email', 'max:255'],
            'hours' => ['nullable', 'string', 'max:255'],
            'maps_url' => ['nullable', 'url', 'max:2048'],
        ], [
            'phone.regex' => 'Phone must be E.164 format with a leading +, e.g. +923251212747.',
            'whatsapp.regex' => 'WhatsApp must be digits only, no + and no leading 0, e.g. 923251212747.',
        ]);

        $validated['is_main'] = $request->boolean('is_main');

        return $validated;
    }
}
