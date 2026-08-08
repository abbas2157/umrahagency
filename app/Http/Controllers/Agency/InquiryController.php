<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\AgencyBranch;
use App\Models\City;
use App\Models\Inquiry;
use App\Models\InquiryActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InquiryController extends Controller
{
    /**
     * Casework for a query once it belongs to an agency: assign to an
     * agent, change status, add notes. Assigning to an agency in the
     * first place is Super Admin's job — see
     * App\Http\Controllers\Admin\InquiryController.
     */
    public function index(Request $request)
    {
        $query = Inquiry::query()->with(['agency', 'assignedAgent'])->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('departure_airport', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('needs_follow_up')) {
            $query->needsFollowUp();
        }

        // departure_airport is free text from the (frozen) public form, but
        // its values are city names — matching against the structured City
        // list gives a clean dropdown instead of free-text search.
        if ($city = City::find($request->input('city_id'))) {
            $query->whereRaw('LOWER(departure_airport) = ?', [strtolower($city->name)]);
        }

        // "Area" has no field of its own on Inquiry — the closest real
        // signal is which branch is handling it, and every branch already
        // carries an area, so filtering by branch doubles as an area filter.
        if ($branchId = $request->input('branch_id')) {
            $query->whereHas('assignedAgent', fn ($q) => $q->where('branch_id', $branchId));
        }

        $inquiries = $query->paginate(20)->withQueryString();

        $needsFollowUpCount = Inquiry::needsFollowUp()->count();

        $cities = City::where('is_active', true)->orderBy('name')->get();
        $branches = AgencyBranch::where('agency_id', auth()->user()->agency_id)->orderBy('name')->get();

        return view('agency.inquiries.index', compact('inquiries', 'needsFollowUpCount', 'cities', 'branches'));
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['agency', 'assignedAgent', 'activities.user']);

        $agents = $inquiry->agency_id
            ? User::where('agency_id', $inquiry->agency_id)->where('role', 'agent')->active()->orderBy('name')->get()
            : collect();

        return view('agency.inquiries.show', compact('inquiry', 'agents'));
    }

    public function assignAgent(Request $request, Inquiry $inquiry)
    {
        if (! auth()->user()->isAgencyAdmin()) {
            abort(403);
        }

        if (! $inquiry->agency_id) {
            throw ValidationException::withMessages(['agent_id' => 'Assign this query to an agency first.']);
        }

        $validated = $request->validate([
            'agent_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'agent')->where('agency_id', $inquiry->agency_id)->where('is_active', true),
            ],
        ]);

        $oldAgent = $inquiry->assignedAgent?->name ?? 'Unassigned';
        $newAgent = User::findOrFail($validated['agent_id']);

        $inquiry->update([
            'assigned_agent_id' => $newAgent->id,
            'assigned_at' => now(),
        ]);

        InquiryActivity::record($inquiry, 'assignment', $oldAgent, $newAgent->name, 'Assigned to agent');

        return back()->with('success', 'Query assigned to '.$newAgent->name.'.');
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Inquiry::STATUSES)],
            'lost_reason' => ['required_if:status,lost', 'nullable', Rule::in(Inquiry::LOST_REASONS)],
        ]);

        $oldStatus = $inquiry->status;

        $inquiry->update([
            'status' => $validated['status'],
            'lost_reason' => $validated['status'] === 'lost' ? $validated['lost_reason'] : null,
        ]);

        InquiryActivity::record($inquiry, 'status_change', $oldStatus, $validated['status'], $validated['lost_reason'] ?? null);

        return back()->with('success', 'Status updated.');
    }

    public function storeNote(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:2000'],
        ]);

        InquiryActivity::record($inquiry, 'note', null, null, $validated['note']);

        return back()->with('success', 'Note added.');
    }
}
