<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AgencyBranch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->ownAgents()->with('branch');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        }

        $agents = $query->latest()->paginate(20)->withQueryString();

        $branches = $this->ownBranches();

        return view('agency.agents.index', compact('agents', 'branches'));
    }

    public function performance()
    {
        $agents = $this->ownAgents()->with('branch')->orderBy('name')->get()
            ->map(fn (User $agent) => ['agent' => $agent, ...$agent->performanceStats()]);

        return view('agency.agents.performance', compact('agents'));
    }

    public function create()
    {
        $branches = $this->ownBranches();

        if ($branches->isEmpty()) {
            return redirect()->route('agency.branches.create')
                ->with('error', 'Add a branch before adding agents — every agent must belong to one.');
        }

        return view('agency.agents.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateAgent($request);
        $validated['role'] = 'agent';
        $validated['agency_id'] = auth()->user()->agency_id;
        $validated['is_active'] = true;

        if ($request->hasFile('photo_file')) {
            $validated['photo'] = User::storePhotoUpload($request->file('photo_file'));
        }
        unset($validated['photo_file']);

        $agent = User::create($validated);

        ActivityLog::record('user_created', "Agent '{$agent->name}' created", $agent->agency_id, 'User', $agent->id);

        return redirect()->route('agency.agents.index')->with('success', 'Agent created.');
    }

    public function edit(User $agent)
    {
        $this->authorizeOwnAgent($agent);

        $branches = $this->ownBranches();

        return view('agency.agents.edit', compact('agent', 'branches'));
    }

    public function update(Request $request, User $agent)
    {
        $this->authorizeOwnAgent($agent);

        $validated = $this->validateAgent($request, $agent);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if ($request->hasFile('photo_file')) {
            $validated['photo'] = User::storePhotoUpload($request->file('photo_file'), $agent->photo);
        }
        unset($validated['photo_file']);

        $agent->update($validated);

        ActivityLog::record('user_updated', "Agent '{$agent->name}' updated", $agent->agency_id, 'User', $agent->id);

        return redirect()->route('agency.agents.index')->with('success', 'Agent updated.');
    }

    /**
     * Agents are never hard-deleted — past enquiries still point to them.
     * Deactivating stops them receiving new work (and, like a deactivated
     * agency, ends their ability to log in) without losing that history.
     */
    public function deactivate(User $agent)
    {
        $this->authorizeOwnAgent($agent);

        $agent->update(['is_active' => false]);

        DB::table('sessions')->where('user_id', $agent->id)->delete();

        ActivityLog::record('agent_deactivated', "Agent '{$agent->name}' deactivated", $agent->agency_id, 'User', $agent->id);

        return redirect()->route('agency.agents.index')->with('success', 'Agent deactivated and logged out.');
    }

    public function activate(User $agent)
    {
        $this->authorizeOwnAgent($agent);

        $agent->update(['is_active' => true]);

        ActivityLog::record('agent_activated', "Agent '{$agent->name}' activated", $agent->agency_id, 'User', $agent->id);

        return redirect()->route('agency.agents.index')->with('success', 'Agent activated.');
    }

    public function sessions(User $agent)
    {
        $this->authorizeOwnAgent($agent);

        $sessions = $agent->activeSessions();

        return view('agency.agents.sessions', compact('agent', 'sessions'));
    }

    public function revokeSession(User $agent, string $sessionId)
    {
        $this->authorizeOwnAgent($agent);

        DB::table('sessions')
            ->where('user_id', $agent->id)
            ->where('id', $sessionId)
            ->delete();

        ActivityLog::record('session_revoked', "A device belonging to '{$agent->name}' was logged out", $agent->agency_id, 'User', $agent->id);

        return back()->with('success', 'Device logged out.');
    }

    /**
     * An agency_admin's Agents screen must never expose another agency's
     * users — this scopes every query the same way the model's global
     * scope already protects Inquiries, but Users has no such scope, so
     * it's enforced explicitly here at the controller boundary instead.
     */
    private function ownAgents()
    {
        return User::where('agency_id', auth()->user()->agency_id)->where('role', 'agent');
    }

    private function authorizeOwnAgent(User $agent): void
    {
        abort_unless(
            $agent->agency_id === auth()->user()->agency_id && $agent->role === 'agent',
            404
        );
    }

    private function ownBranches()
    {
        return AgencyBranch::where('agency_id', auth()->user()->agency_id)->active()->orderBy('name')->get();
    }

    private function validateAgent(Request $request, ?User $agent = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($agent)],
            'password' => [$agent ? 'nullable' : 'required', 'confirmed', 'min:8'],
            // E.164 with a leading + — matches AGENT-ENTITY.md's tel: link format.
            'phone' => ['nullable', 'regex:/^\+[1-9]\d{9,14}$/'],
            // Digits only, no + and no leading 0 — matches AGENT-ENTITY.md's wa.me/ format.
            'whatsapp' => ['required', 'regex:/^[1-9]\d{10,14}$/'],
            'languages' => ['nullable', 'string', 'max:255'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:2048'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            // Every agent belongs to exactly one branch — branches must exist first.
            'branch_id' => ['required', Rule::exists('agency_branches', 'id')->where('agency_id', auth()->user()->agency_id)->where('is_active', true)],
        ], [
            'phone.regex' => 'Phone must be E.164 format with a leading +, e.g. +923251212747.',
            'whatsapp.regex' => 'WhatsApp must be digits only, no + and no leading 0, e.g. 923251212747.',
        ]);
    }
}
