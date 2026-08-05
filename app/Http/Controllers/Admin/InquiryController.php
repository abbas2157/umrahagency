<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Inquiry;
use App\Models\InquiryActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InquiryController extends Controller
{
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

        $inquiries = $query->paginate(20)->withQueryString();

        $agencies = auth()->user()->isSuperAdmin() ? Agency::where('is_active', true)->orderBy('name')->get() : collect();

        return view('admin.inquiries.index', compact('inquiries', 'agencies'));
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['agency', 'assignedAgent', 'activities.user']);

        $agencies = auth()->user()->isSuperAdmin() ? Agency::where('is_active', true)->orderBy('name')->get() : collect();

        $agents = $inquiry->agency_id
            ? User::where('agency_id', $inquiry->agency_id)->where('role', 'agent')->orderBy('name')->get()
            : collect();

        return view('admin.inquiries.show', compact('inquiry', 'agencies', 'agents'));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }

    public function assignAgency(Request $request, Inquiry $inquiry)
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }

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

        $this->logActivity($inquiry, 'assignment', $oldAgency, $newAgency->name, 'Assigned to agency');

        return back()->with('success', 'Query assigned to '.$newAgency->name.'.');
    }

    public function assignAgent(Request $request, Inquiry $inquiry)
    {
        $user = auth()->user();

        if (! $user->isSuperAdmin() && ! $user->isAgencyAdmin()) {
            abort(403);
        }

        if (! $inquiry->agency_id) {
            throw ValidationException::withMessages(['agent_id' => 'Assign this query to an agency first.']);
        }

        $validated = $request->validate([
            'agent_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'agent')->where('agency_id', $inquiry->agency_id),
            ],
        ]);

        $oldAgent = $inquiry->assignedAgent?->name ?? 'Unassigned';
        $newAgent = User::findOrFail($validated['agent_id']);

        $inquiry->update([
            'assigned_agent_id' => $newAgent->id,
            'assigned_at' => now(),
        ]);

        $this->logActivity($inquiry, 'assignment', $oldAgent, $newAgent->name, 'Assigned to agent');

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

        $this->logActivity($inquiry, 'status_change', $oldStatus, $validated['status'], $validated['lost_reason'] ?? null);

        return back()->with('success', 'Status updated.');
    }

    public function storeNote(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:2000'],
        ]);

        $this->logActivity($inquiry, 'note', null, null, $validated['note']);

        return back()->with('success', 'Note added.');
    }

    private function logActivity(Inquiry $inquiry, string $type, ?string $old, ?string $new, ?string $note): void
    {
        InquiryActivity::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'type' => $type,
            'old_value' => $old,
            'new_value' => $new,
            'note' => $note,
        ]);
    }
}
