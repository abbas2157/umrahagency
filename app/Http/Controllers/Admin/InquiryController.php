<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\AgencyBranch;
use App\Models\City;
use App\Models\Inquiry;
use App\Models\InquiryActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InquiryController extends Controller
{
    /**
     * Super Admin's job here is oversight and triage: see everything,
     * assign to an agency, delete. Day-to-day casework (assign to agent,
     * status, notes) happens in the Agency panel once a query has an
     * agency — see App\Http\Controllers\Agency\InquiryController.
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

        if ($request->boolean('needs_routing')) {
            $query->whereNull('agency_id');
        }

        // departure_airport is free text collected by the (frozen) public
        // form, but its values are city names — matching it against the
        // structured City list gives a clean dropdown instead of free-text
        // search, without touching the form itself.
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

        $needsRoutingCount = Inquiry::whereNull('agency_id')->count();

        $agencies = Agency::where('is_active', true)->orderBy('name')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $branches = AgencyBranch::with('agency')->orderBy('name')->get();

        return view('admin.inquiries.index', compact('inquiries', 'agencies', 'needsRoutingCount', 'cities', 'branches'));
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['agency', 'assignedAgent', 'activities.user']);

        $agencies = Agency::where('is_active', true)->orderBy('name')->get();

        return view('admin.inquiries.show', compact('inquiry', 'agencies'));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }

    public function assignAgency(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'agency_id' => ['required', Rule::exists('agencies', 'id')->where('is_active', true)],
        ]);

        $oldAgency = $inquiry->agency?->name ?? 'Unassigned';
        $newAgency = Agency::findOrFail($validated['agency_id']);

        $inquiry->update([
            'agency_id' => $newAgency->id,
            'assigned_agent_id' => null,
            'assigned_at' => now(),
        ]);

        InquiryActivity::record($inquiry, 'assignment', $oldAgency, $newAgency->name, 'Assigned to agency');

        return back()->with('success', 'Query assigned to '.$newAgency->name.'.');
    }
}
